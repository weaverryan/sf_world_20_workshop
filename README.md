# SymfonyWorld 2020 Security Workshop!

Well hi there! This repository holds the starting code for the
[All about Symfony's new Security Component](https://live.symfony.com/2020-world/workshop#all-about-symfony-s-new-security-component)
Symfony World 2020 Workshop.

Please go through the setup details below before the workshop, just
to make sure that everything is ready and working. If you have any
doubts, questions or funny stories, please message me aat
`ryan@symfonycasts.com` or ping me as `weaverryan` on the Symfony Slack!

Then, on the day of the workshop, get ready to nerd-out on security 🤓.

## Setup

First, clone the code from this page and reward yourself with a snack!

To get the app working, follow these steps:

**Download Composer dependencies**

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```
composer install
```

**Database Setup**

The code comes with a `docker-compose.yaml` file and we recommend using
Docker to boot a database container. You will still have PHP installed
locally, but you'll connect to a database inside Docker. This is optional,
but I think you'll love it!

First, make sure you have [Docker installed](https://docs.docker.com/get-docker/)
and running. To start the container, run:

```
docker-compose up -d
```

Next, build the database and execute the migrations with:

```
# "symfony console" is equivalent to "bin/console"
# but its aware of your database container
symfony console doctrine:schema:update --force
symfony console doctrine:fixtures:load
```

(If you get an error about "server closed the connection unexpectedly",
just wait a few seconds and try again - the container is probably still booting).

If you do *not* want to use Docker, just make sure to start your own
database server and update the `DATABASE_URL` environment variable in
`.env` or `.env.local` before running the commands above.

**Start the Symfony web server**

You can use Nginx or Apache, but Symfony's local web server
works even better.

To install the Symfony local web server, follow
"Downloading the Symfony client" instructions found
here: https://symfony.com/download - you only need to do this
once on your system.

Then, to start the web server, open a terminal, move into the
project, and run:

```
symfony serve
```

(If this is your first time using this command, you may see an
error that you need to run `symfony server:ca:install` first).

Now check out the site at `https://localhost:8000`

Have fun!
