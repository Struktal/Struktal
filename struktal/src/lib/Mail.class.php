<?php

use \PHPMailer\PHPMailer\PHPMailer;

class Mail {
    private PHPMailer $mail;

    private array $sender;
    private array $replyTo;
    private array $recipients;
    private array $ccRecipients;
    private array $bccRecipients;

    private string $subject;
    private string $htmlBody;
    private string $textBody;
    private array $attachments;

    public function __construct() {
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = Config->getSmtpHost();
        $this->mail->Port = Config->getSmtpPort();
        $this->mail->SMTPAuth = Config->getSmtpAuth();
        $this->mail->Username = Config->getSmtpUsername();
        $this->mail->Password = Config->getSmtpPassword();
        $this->mail->SMTPSecure = Config->getSmtpSecure();

        $this->recipients = [];
        $this->ccRecipients = [];
        $this->bccRecipients = [];
        $this->sender = [
            "", ""
        ];
        $this->replyTo = [
            "",
            null
        ];

        $this->subject = "";
        $this->htmlBody = "";
        $this->textBody = "";
        $this->attachments = [];
    }

    public function setSender(string $email, ?string $name = null): Mail {
        $this->sender = [
            $email, $name
        ];
        return $this;
    }

    public function setReplyTo(string $email, ?string $name = null): Mail {
        $this->replyTo = [
            $email, $name
        ];
        return $this;
    }

    public function addRecipient(string $email, ?string $name = null): Mail {
        $this->recipients[] = [
            $email, $name
        ];
        return $this;
    }

    public function addCcRecipient(string $email, ?string $name = null): Mail {
        $this->ccRecipients[] = [
            $email, $name
        ];
        return $this;
    }

    public function addBccRecipients(string $email, ?string $name = null): Mail {
        $this->bccRecipients[] = [
            $email, $name
        ];
        return $this;
    }

    public function setSubject(string $subject): Mail {
        $this->subject = $subject;
        return $this;
    }

    public function setHtmlBody(string $htmlBody): Mail {
        $this->htmlBody = $htmlBody;
        return $this;
    }

    public function setTextBody(string $textBody): Mail {
        $this->textBody = $textBody;
        return $this;
    }

    public function addAttachment(string $filePath, ?string $fileName = null): Mail {
        $this->attachments[] = [
            $filePath, $fileName
        ];
        return $this;
    }

    public function send(): void {
        $this->mail->setFrom($this->sender[0], $this->sender[1]);
        $this->mail->addReplyTo($this->replyTo[0], $this->replyTo[1] ?? "");

        if(!Config->redirectAllMails()) {
            foreach($this->recipients as $recipient) {
                $email = $recipient[0];
                $name = $recipient[1];
                $this->mail->addAddress($email, $name ?? "");
            }

            foreach($this->ccRecipients as $recipient) {
                $email = $recipient[0];
                $name = $recipient[1];
                $this->mail->addCC($email, $name ?? "");
            }

            foreach($this->bccRecipients as $recipient) {
                $email = $recipient[0];
                $name = $recipient[1];
                $this->mail->addBCC($email, $name ?? "");
            }
        } else {
            $redirect = Config->getRedirectMailAddress();
            Logger::getLogger("MAIL")->info("Redirecting mail to " . $redirect);
            $this->mail->addAddress($redirect);
        }

        $this->mail->isHTML(!empty($this->htmlBody));
        $this->mail->Subject = $this->subject;
        if(!empty($this->htmlBody)) {
            $this->mail->Body = $this->htmlBody;
            $this->mail->AltBody = $this->textBody;
        } else {
            $this->mail->Body = $this->textBody;
        }

        foreach($this->attachments as $attachment) {
            $filePath = $attachment[0];
            $fileName = $attachment[1];
            $this->mail->addAttachment($filePath, $fileName);
        }

        $this->mail->send();
    }
}
