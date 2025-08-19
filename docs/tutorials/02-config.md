# Config
The framework provides a configuration file that allows you to configure the features of the framework and your application.
It is located in the `📁 config/` directory and named `📄 config/config.json`.

## Default values

| Field name                   | Description                                                                                                                             | Default value           |
|------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------|-------------------------|
| `APP_NAME`                   | The application's name that is displayed in the header and footer                                                                       | `Application`           |
| `APP_URL`                    | The application's URL                                                                                                                   | `http://localhost:3000` |
| `BASE_URI`                   | The base URI of the application (e.g. if the application is hosted as a subdirectory of a domain, the base URI would be that directory) | `/`                     |
| `PRODUCTION`                 | Whether the application runs in a production environment or not                                                                         | `true`                  |
| `LOG_RECIPIENTS`             | The email addresses that should receive log messages when an error occurs                                                               | `[]`                    |
| `LOG_LEVEL`                  | The minimum importance that is required for a message to get written into a logfile                                                     | `6` (trace)             |
| `DB_HOST`                    | Database hostname                                                                                                                       | `database`              |
| `DB_USER`                    | Database username                                                                                                                       | `struktal-app`          |
| `DB_PASS`                    | Database password                                                                                                                       | `struktal-app`          |
| `DB_NAME`                    | Database name                                                                                                                           | `struktal-app`          |
| `DB_ENABLED`                 | Whether the database connection should be established upon app start                                                                    | `true`                  |
| `SMTP_HOST`                  | The hostname of the SMTP server                                                                                                         | `smtp.localhost`        |
| `SMTP_PORT`                  | The port of the SMTP server                                                                                                             | `25`                    |
| `SMTP_USER`                  | The username of the SMTP server                                                                                                         | `username`              |
| `SMTP_PASS`                  | The password of the SMTP server                                                                                                         | `password`              |
| `SMTP_SECURE`                | The security protocol that should be used for the SMTP connection                                                                       | `tls`                   |
| `SMTP_AUTH`                  | Whether the SMTP server requires authentication                                                                                         | `true`                  |
| `REDIRECT_ALL_MAILS`         | Whether all mails should be redirected to a specific email address for testing purposes                                                 | `false`                 |
| `REDIRECT_ALL_MAILS_ADDRESS` | The email address to which all mails should be redirected (if `REDIRECT_ALL_MAILS` is set to `true`)                                    | `mail@struktal`         |

The configuration file can be expanded with any additional fields, e.g. API keys, feature flags, etc.
They can be accessed via the global constant `Config` which extends the `StruktalConfig` class from the [struktal/struktal-config](https://github.com/Struktal/struktal-config) library.
For further information on how to use the config, please refer to the library's documentation.
