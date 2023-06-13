# WSL2 Config
https://learn.microsoft.com/en-gb/windows/wsl/install-manual#step-4---download-the-linux-kernel-update-package

# Download on command and up docker compose
```
$ git clone https://github.com/woeis-me/docker.git
$ cd docker
$ sudo docker compose up -d
```
# Node-Red Config
```  
$ sudo apt-get install npm
$ sudo npm install -g node-red-admin
$ sudo docker exec -it user-nodered sh
$ npx node-red admin hash-pw
```    
the terminal show hash password example is `$2b$08$X8stDRyPOvBU6KCSEi5j8uWeETKA5OKLvegXRnHf3hRUCV7MU2P72`
  
copy to file on /nodered/setting.js 
```
  adminAuth: {
    type: "credentials",
      users: [{
      username: "admin",
      password: "$2b$08$X8stDRyPOvBU6KCSEi5j8uWeETKA5OKLvegXRnHf3hRUCV7MU2P72",
      permissions: "*"
      }]
    },
```

restart nodered service 

--------------------------------------------------------------------------------------------------------------

# Influxdb Config
first influxdb.conf comment in line 263  
```
  #Determines whether user authentication is enabled over HTTP/HTTPS.
  #auth-enabled = true #<------
```

```
$ sudo docker exec -it user-influxdb sh
$ influx
$ create database mydb
$ CREATE USER "admin" WITH PASSWORD 'admin_passwd' WITH ALL PRIVILEGES
$ exit
$ exit
```

On influxdb.conf Uncomment in line 263

```
  #Determines whether user authentication is enabled over HTTP/HTTPS.
  auth-enabled = true #<------
```

restart influxdb service

--------------------------------------------------------------------------------------------------------------

# mqtt Config
```
$ sudo docker exec -it user-mosquitto sh
$ mosquitto_passwd -b /mosquitto/config/password_file user pass
$ exit
```

eample is `> mosquitto_passwd -b /mosquitto/config/password_file admin 12345678`
Then restart mqtt service


# Restart Docker compose 
```
$ docker compose restart
```