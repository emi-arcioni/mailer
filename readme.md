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
- Run `php artisan migrate` and `php artisan db:seed` 

## Use of interfaces and repositories

App\Providers\AppServiceProvider registers the bind between the Interface and Repository.
The respository (MailSenderRepository) connects with the main service that sends mails (and its fallback).

## Services

All sending mail logic are developed within MailjetService and SendgridService.
LogDeliveryService main purpose is to store the delivery log in database 