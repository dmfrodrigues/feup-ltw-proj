# Elements:
 - Breno Accioly (2018xxxxx) 
 - Diogo Rodrigues (2018xxxxx)
 - Rui Pinto (201806441)
 - Tiago Gomes (201806658)

# Credentials
 - dmfr / dmfr (user)
 - AAOrg / AAOrg (shelter)

# Libraries:
 - none

# Features:
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
     - Data Validation: regex, php, html, javascript, ajax
     - Other:
        - Regenerate session: yes
        - Usernames are case insensitive: yes

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
    - Pet comment section
    -  
    - Animal shelters should also be able to register as users
    - Shelters have a dedicated page with all pets available for adoption.
    - Users can be collaborators of a certain shelter and have permission to edit information about the shelter and any pets for adoption.
    - Users that adopt a pet should be able to still post photos of that animal after the adoption.
    - Users should receive a notification anytime something important happens.
    - Develop a REST API.
