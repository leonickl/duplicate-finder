# Duplicate Finder

This script runs a local webserver that lets you remove duplicate photos one by one or folder-wise via a browser-based GUI.

- Install [https://github.com/leonickl/wastebasket](wastebasket), which is used as a trash backend; so the program does not delete any files, but move them to the wastebasket folder.
- Clone this repository (`git clone https://github.com/leonickl/duplicate-finder`).
- Run `composer install` to install dependencies.
- Create `.env` file with `PATH=/path/to/your/photos`.
- Run `./run migrate` to initialize the database.
- Run `./run server` to start the web server and open [http://localhost:8085/](localhost:8085). the port can be adjusted in `config.php`.
- Select `Start Scan` to scan your photos and save their paths and hashes to the database.
- Afterwards, you can remove single duplicate files in `All Duplicates`.
- If you select `Panes View`, you can select a left and a right folder, which will open next to each other. You can bulk-delete all duplicates in one of these folders then by clicking the trash icon (Mind: still shows _all_ duplicates in the folder, not only those that are also in the other one).
