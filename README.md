# ltw-project-g22

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

TODO

## Database

![](https://drive.google.com/uc?id=1GCfSFqCDMwwdoo5dfPFMRIUeBxZViuS2)

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

