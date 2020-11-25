<?php
/* 

Free PHP File Directory Listing Script - Version 1.10 - Edit 1.1

The MIT License (MIT)

Copyright (c) 2015 Hal Gatewood
Edited Dead4W 2020 Ilya Zedgenizov

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


*** OPTIONS ***/

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
    // LOWER CASE!!!
    const IGNORE_FILE_LIST = array( ".htaccess", "thumbs.db", ".ds_store", "index.php" );

    // ADD SPECIFIC FILE EXTENSIONS YOU WANT TO IGNORE HERE, EXAMPLE: array('psd','jpg','jpeg')
    // LOWER CASE!!!
    const IGNORE_EXT_LIST = array( );

    // SORT BY (name_asc, name_desc, date_asc, date_desc)
    const SORT_BY = "name_asc";

    // HIDE .files/.folders
    const HIDE_DOT = true;

    // OPEN LINK IN NEW TAB, WORK IF NOT force_download
    const FILE_NEW_IN_TAB = true;

    // ICON URL
    //$icon_url = "https://www.dropbox.com/s/lzxi5abx2gaj84q/flat.png?dl=0"; // DIRECT LINK
    const ICON_URL = "flat.png";

    // TOGGLE SUB FOLDERS, SET TO false IF YOU WANT OFF
    const TOGGLE_SUB_FOLDERS = true;

    // FORCE DOWNLOAD ATTRIBUTE
    const FORCE_DOWNLOAD = false;

    // IGNORE EMPTY FOLDERS
    const IGNORE_EMPTY_FOLDERS = true;

    // DIR CONST ENUM
    const EDir = "DIR_EXT";

	
// SET TITLE BASED ON FOLDER NAME, IF NOT SET ABOVE
if( !$title ) { $title = clean_title(basename(dirname(__FILE__))); }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0, viewport-fit=cover">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<link href="//fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet" type="text/css" />
	<style>
		*, *:before, *:after { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; }
		body { background: #dadada; font-family: "Lato", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-weight: 400; font-size: 14px; line-height: 18px; padding: 0; margin: 0; text-align: center;}
		.wrap { max-width: 100%; width: 500px; margin: 20px auto; background: white; padding: 40px; border-radius: 3px; text-align: left;}
		@media only screen and (max-width: 700px) { .wrap { padding: 15px; } }
		h1 { text-align: center; margin: 40px 0; font-size: 22px; font-weight: bold; color: #666; }
		a { color: #399ae5; text-decoration: none; } a:hover { color: #206ba4; text-decoration: none; }
		.note { padding:  0 5px 25px 0; font-size:80%; color: #666; line-height: 18px; }
		.block { clear: both; min-height: 50px; border-top: solid 1px #ECE9E9; }
		.block:first-child { border: none; }
		.block .img { width: 50px; height: 50px; display: block; float: left; margin-right: 10px; background: transparent url(<?php echo ICON_URL; ?>) no-repeat 0 0; }
		.block .file { padding-bottom: 5px; }
		.block .data { line-height: 1.3em; color: #666; }
		.block a { display: block; padding: 20px; transition: all 0.35s; }
		.block a:hover, .block a.open { text-decoration: none; background: #efefef; }
		
		.bold { font-weight: 900; }
		.upper { text-transform: uppercase; }
		.fs-1 { font-size: 1em; } .fs-1-1 { font-size: 1.1em; } .fs-1-2 { font-size: 1.2em; } .fs-1-3 { font-size: 1.3em; } .fs-0-9 { font-size: 0.9em; } .fs-0-8 { font-size: 0.8em; } .fs-0-7 { font-size: 0.7em; }
		
		.jpg, .jpeg, .gif, .png { background-position: -50px 0 !important; } 
		.pdf { background-position: -100px 0 !important; }  
		.txt, .rtf { background-position: -150px 0 !important; }
		.xls, .xlsx { background-position: -200px 0 !important; } 
		.ppt, .pptx { background-position: -250px 0 !important; } 
		.doc, .docx { background-position: -300px 0 !important; }
		.zip, .rar, .tar, .gzip { background-position: -350px 0 !important; }
		.swf { background-position: -400px 0 !important; } 
		.fla { background-position: -450px 0 !important; }
		.mp3 { background-position: -500px 0 !important; }
		.wav { background-position: -550px 0 !important; }
		.mp4 { background-position: -600px 0 !important; }
		.mov, .aiff, .m2v, .avi, .pict, .qif { background-position: -650px 0 !important; }
		.wmv, .avi, .mpg { background-position: -700px 0 !important; }
		.flv, .f2v { background-position: -750px 0 !important; }
		.psd { background-position: -800px 0 !important; }
		.ai { background-position: -850px 0 !important; }
		.html, .xhtml, .dhtml, .php, .asp, .css, .js, .inc { background-position: -900px 0 !important; }
		.DIR_EXT { background-position: -950px 0 !important; }
		
		.sub { margin-left: 20px; border-left: solid 5px #ECE9E9; display: none; }
		
		body.dark { background: #1d1c1c; color: #fff; }
		body.dark h1 { color: #fff; }
		body.dark .wrap { background: #2b2a2a; }
		body.dark .block { border-top: solid 1px #666; }
		body.dark .block a:hover, body.dark .block a.open { background: #000; }
		body.dark .note { color: #fff; }
		body.dark .block .data { color: #fff; }
		body.dark .sub { border-left: solid 5px #0e0e0e; }
	</style>
</head>
<body class="<?php echo COLOR_STYLE; ?>">
<h1><?php echo $title ?></h1>
<div class="wrap">
<?php

// FUNCTIONS TO MAKE THE MAGIC HAPPEN, BEST TO LEAVE THESE ALONE
function clean_title($title)
{
	return ucwords( str_replace( array("-", "_"), " ", $title) );
}

function ext($filename) 
{
	return substr( strrchr( $filename,'.' ),1 );
}

function is_dir_good($file) {
    // check if dir have D flag in perms
    return (fileperms("$file") & 0x4000) == 0x4000;
}

function display_size($bytes, $precision = 2) 
{
	$units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= (1 << (10 * $pow)); 
	return round($bytes, $precision) . '<span class="fs-0-8 bold">' . $units[$pow] . "</span>";
}

function count_dir_files( $dir)
{
	$fi = new FilesystemIterator(__DIR__ . "/" . $dir, FilesystemIterator::SKIP_DOTS);
	return iterator_count($fi);
}

function get_directory_size($path)
{
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path))
    {
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object)
        {
            $bytestotal += $object->getSize();
        }
    }
    
    return display_size($bytestotal);
}


// SHOW THE MEDIA BLOCK
function display_block( $file )
{
	
	$file_ext = mb_strtolower(ext($file));
	if( is_dir_good($file) ) $file_ext = EDir;

    $second_attr = "";
    $file_href = (FILE_HANDLER !== false) ? FILE_HANDLER . "?p=" . urlencode($file) : $file;

	if( $file_ext != EDir ) {
        if( FORCE_DOWNLOAD ) {
            if( $file_ext != EDir ) $second_attr = " download='" . basename($file) . "'";
        } else if( FILE_NEW_IN_TAB ) {
            if( $file_ext != EDir ) $second_attr = " target='_blank'";
        }
    }
	
	$rtn = "<div class=\"block\">";
	$rtn .= "<a href=\"$file_href\" class=\"$file_ext\"{$second_attr}>";
	$rtn .= "	<div class=\"img $file_ext\"></div>";
	$rtn .= "	<div class=\"name\">";
	
	if ($file_ext === EDir)
	{
		$rtn .= "		<div class=\"file fs-1-2 bold\">" . basename($file) . "</div>";
		$rtn .= "		<div class=\"data upper size fs-0-7\"><span class=\"bold\">" . count_dir_files($file) . "</span> files</div>";
		$rtn .= "		<div class=\"data upper size fs-0-7\"><span class=\"bold\">Size:</span> " . get_directory_size($file) . "</div>";
		
	}
	else
	{
		$rtn .= "		<div class=\"file fs-1-2 bold\">" . basename($file) . "</div>";
		$rtn .= "		<div class=\"data upper size fs-0-7\"><span class=\"bold\">Size:</span> " . display_size(filesize($file)) . "</div>";
		$rtn .= "		<div class=\"data upper modified fs-0-7\"><span class=\"bold\">Last modified:</span> " .  date("D. F jS, Y - h:ia", filemtime($file)) . "</div>";	
	}

	$rtn .= "	</div>";
	$rtn .= "	</a>";
	$rtn .= "</div>";
	return $rtn;
}


// RECURSIVE FUNCTION TO BUILD THE BLOCKS
function build_blocks( $items, $folder )
{
	$objects = array();
	$objects['directories'] = array();
	$objects['files'] = array();
	
	foreach($items as $c => $item)
	{
		if( $item == ".." OR $item == ".") continue;

		// IGNORE FILE
		if(in_array(mb_strtolower($item), IGNORE_FILE_LIST)) { continue; }
	
		if( $folder && $item )
		{
			$item = "$folder/$item";
		}

		$file_ext = ext($item);
		
		// IGNORE EXT
		if(in_array(mb_strtolower($file_ext), IGNORE_EXT_LIST)) { continue; }

        if( HIDE_DOT AND basename($item)[0] == "." ) { continue; }
		
		// DIRECTORIES
		if( is_dir_good($item) )
		{
			$objects['directories'][] = $item; 
			continue;
		}
		
		// FILE DATE
		$file_time = date("U", filemtime($item));
		
		// FILES
		if( $item )
		{
			$objects['files'][$file_time . "-" . $item] = $item;
		}
	}
	
	foreach($objects['directories'] as $c => $file)
	{
		$sub_items = (array) scandir( $file );
		
		if( IGNORE_EMPTY_FOLDERS )
		{
			$has_sub_items = false;
			foreach( $sub_items as $sub_item )
			{
				$sub_fileExt = ext( $sub_item );
			
				$has_sub_items = true;
				break;	
			}
			
			if( $has_sub_items ) echo display_block( $file );
		}
		else
		{
			echo display_block( $file );
		}
		
		if( TOGGLE_SUB_FOLDERS )
		{
			if( $sub_items )
			{
                $file_href = (FILE_HANDLER !== false) ? FILE_HANDLER . "?p=" . urlencode($file) : $file;
				echo "<div class='sub' data-folder=\"" . $file_href . "\">";
				build_blocks( $sub_items, $file );
				echo "</div>";
			}
		}
	}
	
	// SORT BEFORE LOOP
	if( SORT_BY == "date_asc" ) { ksort($objects['files']); }
	elseif( SORT_BY == "date_desc" ) { krsort($objects['files']); }
	elseif( SORT_BY == "name_asc" ) { natsort($objects['files']); }
	elseif( SORT_BY == "name_desc" ) { arsort($objects['files']); }
	
	foreach($objects['files'] as $t => $file)
	{
		$fileExt = ext($file);
		if(in_array(mb_strtolower($file), IGNORE_FILE_LIST)) { continue; }
		if(in_array(mb_strtolower($fileExt), IGNORE_EXT_LIST)) { continue; }
		echo display_block( $file );
	}
}

// GET THE BLOCKS STARTED, FALSE TO INDICATE MAIN FOLDER
$items = scandir( $scan_path );
build_blocks( $items, false );
?>

<?php if(TOGGLE_SUB_FOLDERS) { ?>
<script type="text/javascript">
	$(document).ready(function() 
	{
		$("a.DIR_EXT").click(function(e)
		{
			$(this).toggleClass('open');
		 	$('.sub[data-folder="' + $(this).attr('href') + '"]').slideToggle();
			e.preventDefault();
		});
	});
</script>
<?php } ?>
</div>
<div style="padding: 10px 10px 40px 10px;"><a href="https://halgatewood.com/free/file-directory-list/">Free PHP File Directory Script</a> (<a href="https://github.com/halgatewood/file-directory-list/">GitHub</a>)</div>
</body>
</html>