# Quest Management System

The Quest Management System is a web-based application designed to create, manage, edit, and view quests. This system can be used in various contexts, such as educational platforms, gaming, or any scenario where tasks or quests are assigned and tracked. The application features a user-friendly interface with functionality to add new quests, edit existing ones, view all quests, and see detailed information about each quest.

## Features

- **Create New Quests**: Users can add new quests with detailed descriptions and requirements.
- **Edit Quests**: Existing quests can be modified, allowing for updates to quest details.
- **View All Quests**: A comprehensive list of all quests in the system, presented in a user-friendly grid format.
- **Quest Details**: Detailed view of individual quests, including descriptions, objectives, and any other relevant information.

## Setup and Installation

To set up the Quest Management System, follow these steps:

1. **Clone the Repository**
   Clone this repository to your local machine using `git clone <repository-url>`.

2. **Database Configuration**
   - Import the `jsonofquestion` database to your MySQL server.
   - Update the database connection settings in `editquest.php` to match your server's credentials (server name, username, password).

3. **Server Setup**
   - Ensure you have PHP and MySQL installed on your server.
   - Place the project files in your server's document root (e.g., `htdocs` for XAMPP, `www` for WAMP).

4. **Access the Application**
   Open your web browser and navigate to the project's location on your server (e.g., `http://localhost/QuestManagementSystem/`).

## Usage

- To **view all quests**, navigate to `allquest.php`. Here, you can see a list of all available quests and navigate to individual quest details or create a new quest.
- To **add a new quest**, click on the "Create New" link on the `allquest.php` page or directly navigate to `newquest.php`.
- To **edit an existing quest**, click on the edit link next to a quest in the list on the `allquest.php` page, which will take you to `editquest.php`.
- To **view details of a quest**, click on the quest title in the list on the `allquest.php` page, which will redirect you to `viewquest.php`.

## Contributing

Contributions to the Quest Management System are welcome. Please feel free to fork the repository, make changes, and submit pull requests.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Contact

For any queries or further assistance, please contact the repository owner.

