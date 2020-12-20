# Forever Home

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

- **Project name:** Forever Home
- **Short description:** A website for posting and adopting pets
- **Environment:** Apache2 and PHP built-in server (Unix)
- **Tools:** HTML/CSS, Javascript, PHP, SQL
- **Institution:** [FEUP](https://sigarra.up.pt/feup/en/web_page.Inicial)
- **Course:** [LTW](https://sigarra.up.pt/feup/en/UCURR_GERAL.FICHA_UC_VIEW?pv_ocorrencia_id=459485) (Web Languages and Technologies)
<!-- - **Project grade:** ??.?/20.0 -->
- **Group members:**
    - [Breno Accioly de Barros Pimentel](https://github.com/BrenoAccioly) (<up201800170@fe.up.pt>)
    - [Diogo Miguel Ferreira Rodrigues](https://github.com/dmfrodrigues) (<up201806429@fe.up.pt>)
    - [Rui Filipe Mendes Pinto](https://github.com/2dukes) (<up201806441@fe.up.pt>)
    - [Tiago Gonçalves Gomes](https://github.com/TiagooGomess) (<up201806658@fe.up.pt>)


## Installing

### Cloning all dependencies

To clone all dependencies (namely PHP libraries), please run
```sh
git submodule update --init --recursive
```

### Build database

To build the database, run
```sh
./deploy-server.sh
```
It may be necessary to change the script's permissions.

### Routing

The REST API component of the server sends requests through `index.php` which are then routed to the correct functions/files. This is unlike what web servers typically do: route the request to the corresponding file in the file system.

#### Apache2

To correctly route the requests, the apache2 application must be able to read `rest/.htaccess`. To do that, you will probably have to change your apache2 configuration file (usually under `/etc/apache2/apache2.conf`), and replace `AllowOverride None` with `AllowOverride All` in the section where apache2 is configured for the directory where you put this repository; usually you put this repository somewhere under `/var/www` or any subfolder of it, so you must change section
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

#### PHP built-in server
For the PHP built-in server, if you set `index.php` as request router then you're fine, since all requests will be properly routed by `index.php` (this script returns false to signal the PHP built-in server to serve the actual file in the file system instead of proceeding in running PHP code).

### Email service
To enable email service, you have to provide valid credentials in file `rest/email.cred`, following the template:
```txt
<email address>
<password>
```

For instance:
```txt
foreverhomeorg@gmail.com
password
```

The actual Gmail email we will use is <foreverhomeorg@gmail.com>.
The corresponding password is to be kept secret, and as such only available on request to our team.

### Running with PHP built-in server

To run this project with the built-in PHP server, you have to run it with the proper arguments so that requests are routed to `index.php`:

```sh
php -S localhost:4000 index.php
```

## Credentials
Username/password (role):

- dmfr/dmfr (user)
- BrenoAccioly/BrenoAccioly (user)
- 2dukes/2dukes (user)
- TiagooGomess/TiagooGomess (user)
- Asdrubal007/Asdrubal007 (user)
- balves/balves (user)
- harold/harold (user)
- Romanoff123/Romanoff123 (user)
- AAOrg/AAOrg (shelter)

## Libraries
- [Google font *Inter*](https://fonts.google.com/specimen/Inter)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer) to interact with remote email (SMTP) servers and send password reset emails

## Features:
- Security
    - XSS: yes
        - Filtering and encoding inputs: yes
        - CSP: yes
    - CSRF: yes
    - SQL using prepare/execute: yes
    - Passwords:
        - bcrypt with salt algorithm: yes
        - at least 7 characters: yes
        - include at least 1 uppercase letter: yes
        - include at least 1 special character: yes
    - Data Validation: regex, php, html, javascript
    - Other:
        - Regenerate session: yes
        - Usernames are case insensitive: yes
        - Password reset with randomly-generated token

- Technologies
    - Separated logic/database/presentation: yes
    - Semantic HTML tags: yes
    - Responsive CSS: yes
    - Javascript: yes
    - Ajax: yes
    - REST API: yes
    - Other:
    
- Usability:
    - Error/success messages: yes
    - Forms don't lose data on error: no

- Minimum requirements: yes

- Extra requirements:
    - See adopted pets.
    - Add and view pet photos.
    - Pet comment section.
    - Private chat between users regarding pet adopted proposals.
    - Animal shelters are also able to register as users.
    - Shelters have a dedicated page with all pets available for adoption.
    - Users can be collaborators of a certain shelter and have permission to edit information about the shelter and any pets for adoption.
    - Users that adopt a pet are able to still post photos of that animal after the adoption.
    - Users should receive a notification anytime something important happens.
    - Develop a REST API (available at URL `rest/rest/`).
    - Reset password system using emails and random tokens (**implemented after demo and before delivery**)

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

# License

© 2020 Breno Pimentel, Diogo Rodrigues, Rui Pinto, Tiago Gomes

All files are licensed under [GNU General Public License v3](LICENSE) by **© 2020 Breno Pimentel, Diogo Rodrigues, Rui Pinto, Tiago Gomes**.

The files not authored by us (if any) are presented as a fundamental complement to this project, and are made available under *fair use for education*.
