# Deploying DEXTE

One Docker container running PHP 7.4 + Apache + MariaDB, bound to localhost,
with nginx on the host proxying to it. Nothing new is exposed publicly.

PHP 7.4 is required — CodeIgniter 3.1.11 predates PHP 8 support (added in
3.1.13). Running in a container is what makes the host's PHP version irrelevant.

## 1. Clone and configure

```bash
cd /var/www
git clone https://github.com/webdesinoprojects/Period-Panty.git dexte
cd dexte
cp .env.example .env
nano .env          # set DB_PASS, and the Razorpay keys when you have them
```

`.env` is gitignored. It must never be committed.

## 2. Build and start

```bash
docker compose up -d --build
docker compose logs -f web      # ctrl-C once you see "Starting Apache"
```

The first build pulls MariaDB from `archive.debian.org`, which is slow. Expect
several minutes.

## 3. Restore the database

The repository contains no SQL dump, and the container never imports one
automatically — a restore on every boot would risk wiping live data. Do it once:

```bash
# copy your dump to the server first, then:
docker compose exec -T web mysql -u root dexte < /path/to/dump.sql
docker compose exec web mysql -u root -N -e \
  "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='dexte'"
```

If the dump came from MariaDB 11 it begins with a sandbox-mode line that the
10.5 client rejects with `Unknown command '\-'`. Strip it:

```bash
sed '1{/^\/\*M!999999\\- enable the sandbox mode \*\//d}' dump.sql \
  | docker compose exec -T web mysql -u root dexte
```

## 4. Point nginx at it

`/etc/nginx/sites-available/dexte`:

```nginx
server {
    listen 80;
    server_name dexte.187-77-188-199.sslip.io;   # real domain later

    client_max_body_size 64M;   # product image uploads

    location / {
        proxy_pass         http://127.0.0.1:8082;
        proxy_set_header   Host              $host;
        proxy_set_header   X-Real-IP         $remote_addr;
        proxy_set_header   X-Forwarded-For   $proxy_add_x_forwarded_for;
        proxy_set_header   X-Forwarded-Proto $scheme;
    }
}
```

`X-Forwarded-Proto` matters: `base_url` is derived from the request, and that
header is how the app knows to emit `https://` URLs once TLS is terminated.

```bash
sudo ln -s /etc/nginx/sites-available/dexte /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

## 5. Add the real domain later

No rebuild needed — `base_url` follows the Host header.

```bash
# add the domain to server_name, then:
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

## Operations

```bash
docker compose logs -f web                 # logs
docker compose restart web                 # restart
git pull && docker compose up -d --build   # deploy an update
docker compose exec -T web mysqldump -u root dexte > backup-$(date +%F).sql
```

### Backups

The database lives in the `dbdata` Docker volume and customer uploads in
`./uploads`. Both survive rebuilds. **Removing the volume destroys the
database** — take the dump above before any `docker compose down -v`.

Running MariaDB inside the application container is fine for getting live, but
it makes backups and upgrades more awkward than a managed database would. Worth
splitting out once the site is settled.

### Before taking real payments

- Rotate the Razorpay keys. The previous pair was committed to git history and
  must be treated as compromised.
- Set `RAZOR_KEY_ID` and `RAZOR_KEY_SECRET` in `.env`; the code no longer
  contains them, so payments will not work until they are set.
