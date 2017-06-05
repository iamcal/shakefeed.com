# ShakeFeed - Best of MLKSHK on a page

I follow the <a href="https://twitter.com/#!/best_of_mlkshk">Best of MLKSHK</a> stream, but it's hard to remember where I left off last time. Have I seen this image in this feed before, or just randomly?

This super simple app just shows the feed as text links, letting my browser remember what I've seen.

## Installation

    cd /var/www/html
    git clone git@github.com:shakefeed.com.git
    ln -s /var/www/html/shakefeed.com/site.conf /etc/apache2/sites-available/shakefeed.com.conf
    a2ensite shakefeed.com
    service apache2 reload
    cd db
    ./init_db.sh

Add the OAuth key and user secrets into `secrets/oauth_secret` and `secrets/oauth_user_secret`.

The crontab is not currently hooked up, since mlkshk is no longer online.
