# Welcome to GamerGurl!

GamerGurl is an online platform designed to create a safe and empowering space for womxn gamers to connect, share experiences, and support one another in the gaming world. Recognizing that womxn often face sexism and harassment in online gaming communities, GamerGurl provides a space where they can freely discuss their interests, find teammates, and build friendships without the pressures often encountered in mixed-gender environments. The platform is dedicated to fostering a positive, inclusive gaming culture that celebrates diversity and camaraderie.

GamerGurl’s core features include forums for game-specific discussions, skill-sharing sessions, and mentorship opportunities, where experienced players can offer advice to those new to gaming. The platform will also include a “Squad Finder” feature to help womxn gamers connect and team up for multiplayer games, with a focus on creating safe and supportive in-game experiences. A resource hub will offer articles, mental health tips, and information on handling harassment, as well as spotlighting womxn-led game streams and tournaments.

GamerGurl will be intuitive and easy to navigate, with personalized profiles and options for privacy controls. It will include community guidelines to ensure respectful interactions. GamerGurl is committed to building a community where womxn can engage with gaming confidently and comfortably, supporting one another both in and out of the game.

## Insert, update, delete, select = resources

### Resource page:
To access the resource page requires login initially, but you can continue as a guest!

I didn't have time to integrate, so I implemented a separate guest view. You can only view resources, comment, and give kudos in guest view.

As a member, you can insert, edit, delete, update your resources.

As admin, you have universal control over all resources.

I tried using all that we studied this semester in this assignment:

- HTML semantics
- CSS (animations also in the header)
- JS for DOM (add event listeners, functions, query selectors, etc)
- PHP for server-side logic.
- AJAX (I tried) to update the UI, though it's not exactly perfect i feel.
- MySQL database for database management.

For some reason, the navigation started giving me problems after I did something with AJAX for resources. For now, I've implemented an inline style in HTML directly for viewing purposes.

I also ended up giving a few divs here and there for responsive purposes.

I tried to organize my code as much as I could for better reading. I'm not perfect on my indenting yet.

### Usage of php, MySQL, and JavaScript components:

### 1. PHP Components

PHP is primarily used for server-side logic, handling requests, and interacting with the MySQL database.

	•	Session Management:
	•	session_start(); is used to maintain user sessions across multiple requests.
	•	Dynamic Content Rendering:
	•	PHP scripts like header.php and footer.php are included to assemble the final HTML output dynamically.
	•	Form Processing:
	•	The form (#resourceForm) sends data to resources.php to handle database operations like inserting or updating resources.
	•	AJAX Endpoint:
	•	The script update-kudos-ajax.php processes kudos updates asynchronously without requiring a full page reload.

    Key Features of PHP (Event Attributes)

	1.	Session Handling (session_start()): Maintains user session data for authentication and authorization.
	2.	Redirection (header()): Redirects unauthorized users to the login page.
	3.	Form Handling ($_POST): Processes data sent via forms for insert, update, and delete actions.
	4.	Prepared Statements ($pdo->prepare()): Protects against SQL injection while querying the database.
	5.	Role-Based Checks ($role): Ensures actions like update and delete are restricted to authorized users.
	6.	Data Fetching ($pdo->query()): Retrieves resource data for display on the page.
	7.	Conditionals (if/else): Implements logic to handle different user actions.
	8.	Dynamic Output (<?= htmlspecialchars() ?>): Safely outputs user-generated content.

### 2. MySQL Components

MySQL handles data storage, retrieval, and updates for resources and kudos.

	•	Database Operations:
	    Resources and user actions (e.g., kudos) are stored in MySQL tables. Queries in resources.php or update-kudos-ajax.php fetch or modify the relevant data. I just have 4 tables, called 'comments', 'contact_messages', 'resources', 'users' with relevant columns like id and names/usernames, passwords, and content.
	•	CRUD Operations:
	    PHP scripts interact with the database to Create, Read, Update, and Delete (CRUD) records based on user actions.
	•	Security:
	    I didn't much focus on password hashing or other methods of security I could've taken to make it better as it was a bit confusing in the database. For some reason, when I created an admin or member directly from the database, it didn't work when I tried logging in. It worked fine when I signed up using the PHP form.

    Key MySQL Features Used

	1.	INSERT INTO: Used to add new resources to the database.
	2.	UPDATE: Updates resource details based on the provided id.
	3.	DELETE FROM: Deletes resources securely by id.
	4.	SELECT * FROM: Fetches all resources to display in a table.
	5.	WHERE: Filters records for specific resource actions (e.g., update, delete).


### 3. JavaScript Components

JavaScript updates the DOM (e.g., kudos count, success messages) without reloading the page.

	•	Form Handling:
	    Dynamically populates the form (populateForm) with resource data for updates.
	    Confirms user actions before submission using confirm().

    •	AJAX Requests:
        Kudos updates (update-kudos-ajax.php) use XMLHttpRequest to send data and receive a response in JSON format, updating the UI dynamically. 
        This took time, and as mentioned to you, is still maybe a tiny bit faulty for the CRUD Operations (it's not doing what I intend for it to be doing and messing up the layout of my page.) But it works fine for my kudos (like) interaction, and I was scared to mess anything up by moving anything around.

        Right now, it's correctly displaying dynamic success/error messages for the contact form.
	    It's updating the the UI (e.g., kudos count) based on server responses.
        For something fun to check, it displays playful messages when users click on Privacy Policy or Terms of Service links. I have to get a handle on preventing default, though.


    •	Contact Form Submission:
	    Uses the fetch API to send the form data asynchronously to contact.php, handling success and error states without page reloads. I know you said fetch() at this stage was a nuclear bomb to use, but I got a handle of it when I worked on my last assignment, so it was just familiar to me.

    Key Features of JavaScript (Event Attributes)

	1.	DOMContentLoaded: Ensures DOM elements are fully loaded before executing scripts.
	2.	addEventListener('click'): Captures click events for buttons (e.g., Edit, Delete, Kudos).
	3.	addEventListener('submit'): Prevents default form submission for AJAX handling.
	4.	confirm(): Displays confirmation dialogs before performing critical actions.
	5.	querySelector() / querySelectorAll(): Selects specific DOM elements for manipulation.
	6.	preventDefault(): Stops default behavior (e.g., form reload) for custom handling.
	7.	XMLHttpRequest: Sends and receives data asynchronously for Kudos functionality.
	8.	fetch(): Handles asynchronous requests for the contact form submission.
	9.	Dynamic Form Population (populateForm()): Pre-fills form fields for the update operation.
	10.	JSON.parse(): Parses server responses to handle AJAX responses dynamically.


I loved making this application. It was a journey of exploration for me. I do admit, I spent a lot of time in the CSS than I should've, as I wanted to make things the way I visioned them. That's just the designer in me.

The error handling was a pain and frustrating, but very rewarding when I finally got it to work. I ended up doing a lot of research to understand and debug. I even managed to make sessions, which, in my last assignment, I wasn't able to do. I guess I was too afraid to start something I couldn't finish in time.

Thanks for reading this document!
