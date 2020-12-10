# ltw-project-g22

## Installing

### Routing

The REST API component of the server sends requests to `server/rest/<path>` to `server/index.php` which are then routed to the correct functions. This is unlike what apache2 typically does: route the request to the corresponding file in the file system.

To correctly route the requests, the apache2 application must be able to read `server/rest/.htaccess`. To do that, you will probably have to change your apache2 configuration file (usually under `/etc/apache2/apache2.conf`), and set and replace `AllowOverride None` with `AllowOverride All` in the section where apache2 is configured for the directory where you put this repository; usually you put this repository somewhere under `/var/www` or any subfolder of it, so you must change section
```txt
<Directory /var/www/>
	Options Indexes FollowSymLinks
	AllowOverride None
	Require all granted
</Directory>
```
to
```txt
<Directory /var/www/>
	Options Indexes FollowSymLinks
	AllowOverride All
	Require all granted
</Directory>
```

You also need to enable some modules with the following commands:

```txt
sudo a2enmod rewrite
sudo a2enmod expires
```

After changing the apache2 configuration and enabling the modules, restart apache2 by running `sudo service apache2 restart`.

### Server constants
Each deploy environment has a specific set of constants. Thus, for each environment you are required to use a different set of constants. Our suggestion is that, when you want to add a set of server constants for a new environment you should create a file `server/server_constants_<environment>.php`.

To use a certain set of server constants, create a symbolic link named `server_constants.php` and make it point to the environment constants file; for instance, for local development you should simply run `ln -s server_constants_localhost.php server_constants.php` from directory `server/`.

## Mockups
#### Register
![Mockup](https://drive.google.com/uc?id=1LiE9tmwayZv44HtkqKMEm6Amxtdo9xo0)
#### Login
![Mockup](https://drive.google.com/uc?id=1CMMBSu_7kW6Z1Asyg_r2VA2CQyjmOqw1)
#### Profile
![Mockup](https://drive.google.com/uc?id=1nDx-48MPNdQrBi7ZvddRLt2jDRs_UHSc)
#### Pet's page
![Mockup](https://drive.google.com/uc?id=1R8egFMrVyw5W_Sg8GzLKycjkwux11o37)
#### Available Pets
![Mockup](https://drive.google.com/uc?id=1q1boomaotDPtginB4RcS4qFh56ktC_L-)
#### Proposals
![Mockup](https://drive.google.com/uc?id=1v0f80EG_d-NqEnSgB-5cBiKADfZZlbuV)

## Navigation

![Navigation](https://drive.google.com/uc?id=1asqZTfWr9scShQpR50hrRdI_UIT_uc0c)

## Database

![Database](https://drive.google.com/uc?id=1GCfSFqCDMwwdoo5dfPFMRIUeBxZViuS2)

Shelter(<ins>id</ins>, name, location, description, pictureUrl, registeredOn)  
Notification(<ins>id</ins>, read, subject, text, user→User)  
User(<ins>username</ins>, password, name, registeredOn, shelter→Shelter)  
Admin(<ins>username</ins>→User)  
Pet(<ins>id</ins>, name, species, age, sex, size, color, location, description, status, postedBy→User)  
FavoritePet(<ins>username</ins>→User, <ins>petId</ins>→Pet)  
Comment(<ins>id</ins>, pet→Pet, user→User, postedOn, text, answerTo→Comment)  
CommentPhoto(<ins>id</ins>, commentId→Comment, url)  
AdoptionRequest(<ins>id</ins>, user→User, pet→Pet, text, outcome)  
AdoptionRequestMessage(<ins>id</ins>, request→AdoptionRequest, text)  

## REST

| Request              | GET                | POST               | PUT                | DELETE             |
|----------------------|--------------------|--------------------|--------------------|--------------------|
| `user`               | :x:                | :x:                | :soon:             | :x:                |
| `user/<id>`          | :soon:             | :x:                | :soon:             | :soon:             |
| `user/<id>/photo`    | :heavy_check_mark: | :x:                | OMW                | OMW                |
| `pet`                | :soon:             | :x:                | :soon:             | :x:                |
| `pet/<id>`           | :soon:             | :soon:             | :soon:             | :soon:             |
| `pet/<id>/comments`  | :heavy_check_mark: | :x:                | :x:                | :x:                |
| `comment/photo`      | :x:                | :x:                | :heavy_check_mark: | :x:                |
| `comment/<id>`       | :soon:             | :soon:             | :heavy_check_mark: | :x:                |
| `comment/<id>/photo` | :soon:             | :x:                | :heavy_check_mark: | :heavy_check_mark: |
