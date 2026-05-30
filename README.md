Database web-interface for registered site users
==============
In this project I made a page with all users in database


### Main functionality
1. Sorting users by ID, Login, Name, Surname and Birthday
2. Pagination: on admin_panel you can see only 5 users in time, but you can switch to another pages to see more users
3. Creating user: you can add new users in database
4. Edit user: you can edit information of user
5. Delete user: you can delete user from database

### Instruction how to use this project
1. After downloading repository start Docker
2. In IDE open folder with this project
3. Then in IDE open Terminal and make this comand: "docker compose up -d --build"
4. After starting you can go to the URL: "localhost:8080"
5. There you can see mini instruction: create superuser, log in and u can see users in database

#### Notice
Database with nessessary tables will create by script create_db.sql

#### Versions
Apache - 2.4.67
MySQL - 8.4
PHP - 8.4.21
