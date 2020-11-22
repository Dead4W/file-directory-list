# Free Super Clean PHP File Directory Listing Script

Easily display files and folders in a mobile friendly, clean and cool way. Just drop the `index.php` in your folder and you are ready to go. Past versions of this script can be found here: https://halgatewood.com/free/file-directory-list/

## Options 

```php
// PATH FOR SCAN FILES
$scan_path = dirname(__FILE__);

// TITLE OF PAGE
$title = "List of Files";

// FILE HANDLER, example handle.php?p={FILE}
//const FILE_HANDLER = "handle.php";
const FILE_HANDLER = false;

// STYLING (light or dark)
const COLOR_STYLE	= "light";

// ADD SPECIFIC FILES YOU WANT TO IGNORE HERE
const IGNORE_FILE_LIST = array( ".htaccess", "Thumbs.db", ".DS_Store", "index.php" );

// ADD SPECIFIC FILE EXTENSIONS YOU WANT TO IGNORE HERE, EXAMPLE: array('psd','jpg','jpeg')
const IGNORE_EXT_LIST = array( );

// SORT BY (name_asc, name_desc, date_asc, date_desc)
const SORT_BY = "name_asc";

// HIDE .files/.folders
const HIDE_DOT = true;

// OPEN LINK IN NEW TAB, WORK IF NOT force_download
const FILE_NEW_IN_TAB = true;

// ICON URL, use "https://www.dropbox.com/s/lzxi5abx2gaj84q/flat.png?dl=0" for remote image
const ICON_URL = "data:image/png;base64,............";

// TOGGLE SUB FOLDERS, SET TO false IF YOU WANT OFF
const TOGGLE_SUB_FOLDERS = true;

// FORCE DOWNLOAD ATTRIBUTE
const FORCE_DOWNLOAD = false;

// IGNORE EMPTY FOLDERS
const IGNORE_EMPTY_FOLDERS = true;
```