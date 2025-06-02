  File: readme.txt
  Student : Xu Yan
  Student ID: mng2178
1. File list
    admin.html  -- Frontend interface for admin to search and assign bookings.
    admin.php   -- Backend PHP script to process search and update requests from the admin interface.
    admin.css   -- Stylesheet for admin page layout and formatting.
    booking.html --Frontend interface for client to book a taxi.
    booking.php  --Backend PHP script to handle booking requests and store them in the database.
    booking.css  --Stylesheet for the booking page layout and formatting.
    mysqlcommand.txt --SQL script to create the booking table and insert
    readme.txt    --Lists all files and usage instructions.
2. How to Use the System
For Customers (booking.html):
  - Open `booking.html` in a browser.
  - Fill in pickup details including name, phone number, pickup location,desitnation,pick up date, and time.
  - The form validates input and submits data using AJAX to `booking.php`.
  - A reference number and pickup info(date,time) will be displayed below if successful.

For Admins (admin.html):
  - Open `admin.html` in a browser.
  - To view all unassigned bookings within the next 2 hours, leave the input field empty and click the Search button.
  - Click "Assign" next to a booking to mark it as assigned using AJAX (handled in `admin.php`).
  - Input reference number in a format(BRN00001).Click search button，If the booking exists, its details will be displayed.