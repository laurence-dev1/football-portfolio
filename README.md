# Football Portfolio App
Laurence Suarez (laurence-dev1@github)

**The Project is for portfolio/practice purposes only.**

**Table of Contents:**
* [Credits](#credits)
* [Tech Stack](#techstack)
* [Features](#features)
* [Try the App](#try)

<a id="credits"></a>
### Credits
* All Football data provided by the [Football-Data.org](https://www.football-data.org/) API | Free Tier
* All icons (svg) are from [IconPacks](https://www.iconpacks.net/).
* No image used in this app is mine. Credits to the owners of all images that were used.

<a id="techstack"></a>
### Tech:
* [Laravel](https://laravel.com/) (Laravel 10, PHP 8)
* [Vue](https://vuejs.org/) 3 (With [Pinia](https://pinia.vuejs.org/))
* [InertiaJS](https://inertiajs.com/)
* MySQL (Local) | PostgreSQL (Local/Prod)

<a id="features"></a>
### Features:
* **View**, **filter** and **bookmark (for logged in users)** various Football Data
    * Football Matches
        * Can be filtered via date range
        * Can be filtered via competition
    * Football Competitions *(Planned, To be available soon)*
    * Football Teams *(Planned, To be available soon)*
    * Persons in Football e.g. Players, Managers, Referees *(Planned, To be available soon)*

<a id="try"></a>
### Try the App
The app will be served via [Vercel (Hobby Tier)](https://vercel.com/) and [ElephantSQL (Free Tier)](https://www.elephantsql.com/) for PostgreSQL storage.

To run on Vercel, community's PHP runtime (**vercel-php@0.6.0**) was used: https://github.com/vercel-community/php

- Check it out here: https://football-portfolio.vercel.app

**Or Local Environment Setup?**
1. Clone/Fork the repository.
2. Set up/Create **.env** file, you may copy the contents from the **.env.example** file included in the repository as a basis.
3. Update and add new keys on the created **.env** file

<table>
    <thead>
        <tr>
            <th colspan="2">Update Keys</th>
        </tr>
        <tr>
            <th>Key</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>DB_CONNECTION</td>
            <td>**mysql/pgsql**</td>
        </tr>
        <tr>
            <td>DB_HOST</td>
            <td>**Your local db host**</td>
        </tr>
        <tr>
            <td>DB_PORT</td>
            <td>**Your local db port**</td>
        </tr>
        <tr>
            <td>DB_DATABASE</td>
            <td>football-portfolio (can be any name, make sure the database is existing)</td>
        </tr>
        <tr>
            <td>DB_USERNAME</td>
            <td>**Your local db username**</td>
        </tr>
        <tr>
            <td>DB_PASSWORD</td>
            <td>**Your local db password**</td>
        </tr>
        <tr>
            <td>QUEUE_CONNECTION</td>
            <td>database (jobs are being saved in database)</td>
        </tr>
    </tbody>
</table>

**_Optional_**: If you want to check email sending feature (one after successful user registration) make sure to update the **MAIL_*** keys as well

<table>
    <thead>
        <tr>
            <th colspan="2">Add Keys</th>
        </tr>
        <tr>
            <th>Key</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>FOOTBALL_API_URL</td>
            <td>http://api.football-data.org/v4</td>
        </tr>
        <tr>
            <td>FOOTBALL_API_KEY</td>
            <td>This is necessary. To have yours, register an account on <a href="https://www.football-data.org">Football-Data.org</a></td>
        </tr>
    </tbody>
</table>

4. Run **composer install** and **npm install** to install dependencies.
5. Run **php artisan migrate** to migrate DB tables.
6. Run **npm run dev** / **npm run build** to compile front-end resources.
7. Run your local server and access the app.
