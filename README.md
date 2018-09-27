# Find it for me

This project is a simple PHP parser for the website *Leboncoin.fr*.

## What do I need?

All you need is PHP 7.0, at least, and composer, or docker, and optionally docker-compose.

## How do I install it?

All you have to do is run a composer install, and duplicate the parameters :

```bash
composer install
cp parameters.yml.dist parameters.yml
```

## How do I configure it?

All you have to do is edit the `parameters.yml` file :

- The **smtp** section is about how it will send mail.
- The **mail** part is about the email you will receive.
- The **leboncoin** part is about the website and your region. You can find you region id by processing a search on
*Leboncoin.fr* on your web browser (with you region defined), and having a look at the parameter **regions**.

## And finally, how do I run it?

You can run it using 3 different ways, depending on your dependencies :
- If you only have PHP on your computer/server, just run `php find.php`
- If you have docker on your computer/server, you can run 
`docker run -v $(pwd):/var/www/findItForMe php:7.0-cli php /var/www/findItForMe/find.php`
- If you also have docker-compose, you can run : `docker-compose run findItForMe`

The command has some options :

- **-nm** or **--no-mail**: if set, you won't receive any mail on this run. This is usefull to avoid getting 35 ads when
you run the command for the first time. (Default: false)
- **-v** or **--verbose**: if set, ads will be displayed on the standard output, with this format:
`title|price|url`. (Default: false)
- **-i** or **--ignore-no-price**: this option is used to tell that you don't want ads that do not have a price.
(Default: false)
- **-r** or **--range**: this option authorize you to set the price range. For example `20-100` means you will only
receive ads with prices between 20 and 100 euros. A range has to be two numerics separated by a dash. (Default: none)
- **-min** or **--min-price**: this option can be used to define only the minimum price of the ads you will receive.
(Default: none)
- **-max** or **--max-price**: this option can be used to define only the maximum price of the ads you will receive.
(Default: none)

After (or before, or in the middle) of all those options, you can add arguments.
Each argument should have this follow this template : `name:value`.
Those arguments will be used on the HTTP request to *Leboncoin.fr*.

For example, to define the text of your search, add `text:lampshade` to your command.

If you want to search in the title of the ad only, add `search_in:subject`.

Let's have a full example :

```bash
php find.php -s -min 100 -i text:senic
```

This one will look for **scenic** with a minimum price of **100** euros, but also if there is **no price** on the ad.
It will set those ads to your database, but it will not send you an email.

```bash
php find.php --range 100-400 text:portable category:15 search_in:subject
```

This one will look for **portable** with a price between **100** euros and **400** euros, but only if they have a price.
It only look in the category with the id **15**, which is the "Informatique" category, and it only looks for you search
in the **ad title**.
