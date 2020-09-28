### Gereklilikler 

### Postgresql
~~~~
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" |sudo tee  /etc/apt/sources.list.d/pgdg.list
sudo apt -y install postgresql-12 postgresql-client-12
sudo passwd postgres
sudo systemctl start postgresql.service
sudo systemctl enable postgresql.service
~~~~

### Yükleme 

````
cp .env.example .env

composer install

npm cache clean --force

npm install

````

### Veritabanı Tablolarının Oluşturulması
````
./bin/console doctrine:database:create
./bin/console doctrine:schema:create
````

### Veritabanı Tablolarının Güncelleştirilmesi
````
./bin/console doctrine:schema:update --force
````


### Frontend Derlenmesi
````
npm run watch
````

### Sistemin Çalıştırılması http://127.0.0.1:8000
````
symfony server:start

npm run watch
````