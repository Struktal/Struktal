<div align="center">

<!--![Header](docs/img/header.jpg)-->

# Struktal

### Powerful and feature-rich PHP framework designed to simplify web development

Built-in support for data access and manipulation, routing and various other utilities make it easier to handle common web development tasks.

[Introduction](#introduction) • [Application setup](#application-setup) • [Dependencies](#dependencies) • [License](#license)

</div>

<hr>

## Introduction

This framework is designed to simplify web development by providing a scalable architecture and a set of useful features that are often needed when developing web applications. The most notable features are:
- **GitHub Actions pipeline** to automatically build, test and deploy the application
- The **router** which allows to define specific routes for the website
- **Template files** to strictly separate logic from view - as intended by the MVC pattern
- The **data access object pattern** allows to easily access and manipulate data in the database by using objects (and inheritance)
- A **safe** and **ready-to-use** user management (and login) system which can also handle multiple account types
- A **translator** which helps you to internationalize your web application
- Methods which help to **design RESTful APIs**
- **Info messages** that provide a simple way to display info, warning, error and success messages to the user from PHP and JavaScript
- Accessible **SEO settings** which define how the website should be displayed by search engines and social media platforms

### Running a development environment

To run a development environment, you can use
```sh
composer run dev
```
which will build and run a Docker container with the application and a MySQL database.
You can then access the website on your browser by visiting `http://localhost:3000`.

> [!IMPORTANT]
> If you don't have the Docker-Compose plugin (`docker compose`) installed on your system and instead use `docker-compose`, you have to change the syntax of the executed command in the `📄 composer.json` file.

### Deployment options
Applications which where built with this framework can be deployed either in form of a Docker container or directly to an Apache web server.

The `📄 docker-compose.yml` file provides a Docker Compose infrastructure, which includes the application itself, a MySQL database and a backup service that creates a backup of the database every four hours, by using the `mysqldump` command.

### Prerequisites
When deploying the application, the following prerequisites have to be met:

For Docker deployment,
- Docker and ideally also Docker Compose need to be installed
- The container has to be accessible from outside (e.g. through port mapping, which is already configured, or a reverse proxy)

For deployments to a web server,
- The server has to run PHP 8.3 or higher
- A MySQL or MariaDB database has to be available (if it's required by the application)

> [!TIP]
> It's recommended to use the Docker deployment, as it's much easier to set up and to maintain because everything is already preconfigured. Also, some of the frameworks features such as the automatic crontab setup or the database backup service are exclusive to the Docker deployment option and, if you want to use them on a web server, you'd have to set them up manually.

## Application setup

### Repository setup
- Use this repository as a template for your application by clicking on the green button "Use this template" on the top of this page. This will create a copy of the repository in your account.
- Under the repository's `Settings` > `Actions` > `General`, change the workflow permissions from "Read repository contents and packages permissions" to "Read and write permissions" to allow the pipeline to add the newly built package to the GitHub Container Registry.
- Create repository variables and secrets for GitHub Actions:

  | Variable name          | Description                                                         |
    |------------------------|---------------------------------------------------------------------|
  | `AUTODEPLOY_ACTIVATED` | Whether or not the automatic deployment feature should be activated |
  | `AUTODEPLOY_BASE_URL`  | The base URL of the website                                         |

  | Secret name                | Description                                                                                          |
    |----------------------------|------------------------------------------------------------------------------------------------------|
  | `AUTODEPLOY_AUTH_USERNAME` | The username that is used to authenticate when calling the website (if not required, leave it empty) |
  | `AUTODEPLOY_AUTH_PASSWORD` | The password that is used to authenticate when calling the website (if not required, leave it empty) |

### Local setup
- Clone the newly created repository onto your local machine.
- Configure the `📄 composer.json` file according to your needs: Change the applications' name, description and license, and add required dependencies. If you don't have the Docker Compose plugin installed, but instead use `docker-compose`, you have to change the syntax of the `dev` command.
- Configure `📄 config/config.json.dist` according to your needs, except for secrets such as database credentials. They are treated in the copy of this file, wich won't be tracked by git.
- Copy `📄 config/config.json.dist` to `📄 config/config.json` and configure it according to your needs. This file is ignored by the `.gitignore` file and therefore not included in the repository. You can also store secrets such as database credentials in this file.
- Configure `📄 public/deployment/deploy-config.json` according to your needs.
- Commit and push the changes to the repository.

### Deployment setup - Docker
- Create and configure the `📄 docker-compose.yml` file according to your requirements. The easiest way to do this is by simply cloning the newly created repository onto the server that the Docker container should run on, and then configuring it.
    - Change the `image` name / link
    - Change the access credentials for the database
- Copy `📄 config/config.json` from your local setup to the `📁 config/` directory on the server, or configure the file directly on the server, depending on your needs.
    - Change the database access credentials, as configured in the `📄 docker-compose.yml` file
    - Make sure to set the `PRODUCTION` field to `true`, which will hide error messages from the user
- Run `docker-compose up -d` to start the container. This will pull the image from the GitHub Container Registry and start the container.

### Deployment setup - Apache web server
The deployment to an Apache web server is a bit more complex than the Docker deployment, as you have to set up the server yourself. However, the following steps will guide you through the process:
- Clone the newly created repository onto the web server, e.g. to `/var/www/your-application-name`. This should be done as the web server user, or alternatively, you can set the files' owner afterward through `chown` command.
- Copy `📄 config/config.json` from your local setup to the `📁 config/` directory on the server, or copy the `📄 config/config.json.dist` file to `📄 config/config.json` and configure it according to the servers needs.
- Run `composer build` within the repository directory to install the required dependencies and generate the required application structure. Make sure to run this command as the web server user, too.
- Set up a virtual host for the website. The `DocumentRoot` should point to the directory where you've cloned the repository to, and then `📁 public/`. If you've used the example path from above, the `DocumentRoot` should be set to `/var/www/your-application-name/public`.

## Dependencies
This framework contains the following dependencies:
- **Struktal-Config** - GitHub: [Struktal/struktal-config](https://github.com/Struktal/struktal-config), licensed under [MIT license](https://github.com/Struktal/struktal-config/blob/main/LICENSE)
- **Struktal-Logger** - GitHub: [Struktal/struktal-logger](https://github.com/Struktal/struktal-logger), licensed under [MIT license](https://github.com/Struktal/struktal-logger/blob/main/LICENSE)
- **Struktal-Router** - GitHub: [Struktal/struktal-router](https://github.com/Struktal/struktal-router), licensed under [MIT license](https://github.com/Struktal/struktal-router/blob/main/LICENSE)
- **Struktal-API** - GitHub: [Struktal/struktal-api](https://github.com/Struktal/struktal-api), licensed under [MIT license](https://github.com/Struktal/struktal-api/blob/main/LICENSE)
- **Struktal-ORM** - GitHub: [Struktal/struktal-orm](https://github.com/Struktal/struktal-orm), licensed under [MIT license](https://github.com/Struktal/struktal-orm/blob/main/LICENSE)
- **Struktal-Auth** - GitHub: [Struktal/struktal-auth](https://github.com/Struktal/struktal-auth), licensed under [MIT license](https://github.com/Struktal/struktal-auth/blob/main/LICENSE)
- **Struktal-Validation** - GitHub: [Struktal/struktal-validation](https://github.com/Struktal/struktal-validation), licensed under [MIT license](https://github.com/Struktal/struktal-validation/blob/main/LICENSE)
- **Struktal-Translator** - GitHub: [Struktal/struktal-translator](https://github.com/Struktal/struktal-translator), licensed under [MIT license](https://github.com/Struktal/struktal-translator/blob/main/LICENSE)
- **BladeOne** - GitHub: [EFTEC/BladeOne](https://github.com/EFTEC/BladeOne), licensed under [MIT license](https://github.com/EFTEC/BladeOne/blob/master/LICENSE)
- **TailwindCSS** - GitHub: [tailwindlabs/tailwindcss](https://github.com/tailwindlabs/tailwindcss), licensed under [MIT license](https://github.com/tailwindlabs/tailwindcss/blob/next/LICENSE)
- **Struktal-Curl** - GitHub: [Struktal/struktal-curl](https://github.com/Struktal/struktal-curl), licensed under [MIT license](https://github.com/Struktal/struktal-curl/blob/main/LICENSE-MIT)
- **Struktal-PHPMailer-Wrapper** - GitHub: [Struktal/struktal-phpmailer-wrapper](https://github.com/Struktal/struktal-phpmailer-wrapper), licensed under [LGPL-2.1 license](https://github.com/Struktal/struktal-phpmailer-wrapper/blob/main/LICENSE)
- **PHPMailer** - GitHub: [PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer), licensed under [LGPL-2.1 license](https://github.com/PHPMailer/PHPMailer/blob/master/LICENSE)
- **Struktal-InfoMessages** - GitHub: [Struktal/struktal-infomessages](https://github.com/Struktal/struktal-infomessages), licensed under [MIT license](https://github.com/Struktal/struktal-infomessages/blob/main/LICENSE)
- **Struktal-File-Uploads** - GitHub: [Struktal/struktal-file-uploads](https://github.com/Struktal/struktal-file-uploads), licensed under [MIT license](https://github.com/Struktal/struktal-file-uploads/blob/main/LICENSE-MIT)
- **Struktal-CSV-Reader** - GitHub: [Struktal/struktal-csv-reader](https://github.com/Struktal/csvreader), licensed under [MIT license](https://github.com/Struktal/struktal-csv-reader/blob/main/LICENSE)
- **Struktal-Geocoding-Util** - GitHub: [Struktal/struktal-geocoding-util](https://github.com/Struktal/struktal-geocoding-util), licensed under [GPL-2.0 license](https://github.com/Struktal/geocoding-util/blob/main/LICENSE-GPL2)
- **Struktal-Composer-Reader** - GitHub: [Struktal/struktal-composer-reader](https://github.com/Struktal/struktal-composer-reader), licensed under [MIT license](https://github.com/Struktal/struktal-composer-reader/blob/main/LICENSE)
- **pest** - GitHub: [pestphp/pest](https://github.com/pestphp/pest), licensed under [MIT license](https://github.com/pestphp/pest/blob/2.x/LICENSE.md)

## License
This software is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
