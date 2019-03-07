# Mailer by Emilio Arcioni

The main goal of this service is to send transactional emails

## Installation

- Setup the variables in the .env file
	- MAIL_FROM_EMAIL
	- MAIL_FROM_NAME
	- MJ_APIKEY_PUBLIC (for Mailjet)
	- MJ_APIKEY_PRIVATE (for Mailjet)
	- SENDGRID_API_KEY (for Sendgrid)
- If you want to use the queue service change the variable `QUEUE_CONNECTION` in the .env to `database`

### Docker
- Run `docker-compose up -d --build` at the root of the project
- Run `docker exec mailer_php_1 html/artisan migrate --seed`
- The app will be accessible in http://localhost:8080

To keep the queue worker alive please run
`docker exec mailer_php_1 html/artisan queue:work`

## Use of interfaces and repositories

App\Providers\AppServiceProvider registers the bind between the Interface and Repository.
The respository (MailSenderRepository) connects with the main service that sends mails (and its fallback).

## Services

All sending mail logic are developed within MailjetService and SendgridService.
LogDeliveryService main purpose is to store the delivery log in database 