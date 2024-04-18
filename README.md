# Dockerized Microservices Application
> A microservices app for listening and managing music access with multiple languages and databases

Binotify application is a system that enables user Binotify to play a music and add/update/delete music as well. This app also enables the users to subscribe to artist to get access to premium songs. On separate interface, the admin can approve and manage premium songs. 

## High Level Description
![High Level Design](assets/high-level-design.png)

1. Binotify App (PHP + PostgreSQL + HTML-CSS-JS):

    This application is main interface for the regular user. This application is developed using PHP and PostgreSQL. This app enables the user to manage musics and play the musics inside the application. In addition, this app use `stale-while-revalidate` mechanism to optimize the rendering performance while sync the data with the other services.

2. Binotify Premium App (ReactJS):

    This application is main interface for the admin. This app enables the admin to manage the premium songs and the regular user access to premium songs by subscription. This app is developed using ReactJS and MaterialUI (MUI)

3. Binotify REST Service (TypeScript + ExpressJS + Prisma):
    
    This REST service manages the premium songs which accessed from the React App. This service provides auth and premium songs CRUD features. This service is developed using TypeScript language and ExpressJS framework and Prisma as Database ORM.

4. Binotify SOAP Service (Java + JAX-WS):

    This SOAP service is a service that provide single source of truth for subscription. This service is providing interface as SOAP interface, a messaging protocol specification using XML. This service also provide callback functionality to update other services data, making sure data consistency

## Detailed Specification and Documentations
You can find the details of app specification and the documentation for each of the app here
- [App Specification (Indonesian Language)](assets/Spesifikasi%20Tugas%20Besar%20II%20IF3110%202022_2023%20(1).pdf)
- [React App Documentation](binotify-premium-app-v3/binotify-premium-app-v3/README.md)
- [PHP App Documentation](binotify-app-php-v2/binotify-app-php-v2/README.md)
- [REST Service Documentation](binotify-rest-service-v2/binotify-rest-service-v2/README.md)
- [SOAP Service Documentation](service-soap-v1/service-soap-v1/README.md)

## Several Sequence Diagrams
1. Create Subscription Sequence Diagram
![Create Subscription Sequence Diagram](assets/create-subscription-sequence-diagram.png)

2. Subscription Approval Sequence Diagram
![Subscription Approval Sequence Diagram](assets/subscription-approval-sequence-diagram.png)

3. Fetch Premium Songs Sequence Diagram
![Fetch Premium Songs Sequence Diagram](assets/fetch-premium-songs-sequence-diagram.png)


## Sneak Peaks
### PHP App

1. Home Page
![Home](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/home.png)
2. Album List Page
![Daftar Album](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/daftaralbum.png)
3. Search, Sort and Filter View
![Search, Sort and Filter](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/search.png)
4. Song Detail Page
![Detail Lagu](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/detaillagu.png)
5. Add Song Page
![Tambah Lagu](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/insertsong.png)
6. Song Edit Page
![Edit Lagu](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/editlagu.png)
7. Album Detail Page
![Detail Album](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/detailalbum.png)
8. Insert Album Page
![Tambah Album](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/insertalbum.png)
9. User List Page
![Daftar User](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/userlist.png)
10. Premium Artists Page
![Premium Artists](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/premiumartists.png)
11. Premium Songs Page
![Premium Songs](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/premiumsongs.png)
12. Login Page
![Login](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/login.png)
13. Register Page
![Register](binotify-app-php-v2/binotify-app-php-v2/docs/imgs/register.png)

### React App
1. Login Page
![Login](binotify-premium-app-v3/binotify-premium-app-v3/docs/img/binotify-login.png)

2. Register Page
![Register](binotify-premium-app-v3/binotify-premium-app-v3/docs/img/binotify-register.png)

3. Subscription Request Page
![Subscription Request](binotify-premium-app-v3/binotify-premium-app-v3/docs/img/binotify-request.png)

4. Acccept Subscription Request Modal
![Accept Subscription](binotify-premium-app-v3/binotify-premium-app-v3/docs/img/binotify-accept.png)

5. Manage Song Page
![Manage Song](binotify-premium-app-v3/binotify-premium-app-v3/docs/img/binotify-request.png)

6. Song Creation Page
![Create Song](binotify-premium-app-v3/binotify-premium-app-v3/docs/img/binotify-create.png)

7. Song Edit Page
![Edit Song](binotify-premium-app-v3/binotify-premium-app-v3/docs/img/binotify-edit.png)

