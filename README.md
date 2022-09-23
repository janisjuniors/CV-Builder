<h1>CV Builder</h1>
<p>Application for CV creation with download feature.</p>
<p>Technologies used:</p>
<ul>
    <li>PHP 8</li>
    <li>MySQL 8</li>
    <li>Laravel v9.19</li>
    <li>Vue.js v3.2</li>
    <li>TailwindCSS v3.1</li>
    <li>Docker v20.10</li>
</ul>
<br>
<p align="center">Download CV View</p>

<div align="center">

![Screenshot from 2022-09-22 15-31-41](https://user-images.githubusercontent.com/104723218/191785664-bc11c95b-ee3d-42dd-81a4-5acab8042084.png)

</div>

<p>To download CV and get the expected result make sure to:</p>
<ul>
    <li>Switch margins to none</li>
    <li>Turn on background graphics</li>
    <li>Turn off headers and footers</li>
</ul>
<p>
Depending on the browser, you might need to experiment with the settings for the best pdf result. 
</p>



<h2>Instructions To Set Up Project With Laravel Sail</h2>


<h3>First Time Setup</h3>

<p>Clone or download the repository.</p>
<p>Install <a href="https://docs.docker.com/engine/install/">docker</a> and <a href="https://docs.docker.com/compose/install/">docker-compose</a></p>
<p>Open terminal and go into the project directory.</p>
<p>Create a copy of <code>.env.example</code> and name it <code>.env</code></p>
<p>Run below command to download vendor folder:</p>
<pre>
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
</pre>

<p>Run these commands to create, start and setup containers. 
<br>Run them one by one.
</p>
<pre>
./vendor/bin/sail up -d
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan migrate
./vendor/bin/sail php artisan db:seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
</pre>

<p>After running all the above commands open <a href="http://127.0.0.1:8000/">localhost</a></p>

<h3>After First Time Setup</h3>
<pre>
./vendor/bin/sail up -d
./vendor/bin/sail npm run dev
</pre>


<p>To shut down containers:</p>
<pre>./vendor/bin/sail down</pre>
