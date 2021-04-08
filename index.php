<?php 

	include "FileCleaner.php";

	//Get the folder pathname from the user
	echo "Please enter the root folder pathname: \n";
	$rootPathname = trim(fgets(STDIN));
	if (!is_dir($rootPathname)) {
		while (!is_dir($rootPathname)) {
			echo "Incorrect the root folder pathname! Please enter the correct root folder pathname: \n";
			$rootPathname = trim(fgets(STDIN));
			if (is_dir($rootPathname)) {
				break;
			}
		}
	}

	//Get the additional param delete or not delete the folder
	echo "Should the folder will be deleted? Enter: \n 1 - if yes; \n 0 - if no; \n";
	$emptyDelete = intval(fgets(STDIN));

	//Validate the additional param
	if ($emptyDelete != 1 && $emptyDelete != 0) {
		while ($emptyDelete != 1 && $emptyDelete != 0) {
			echo "Incorrect value for emptyDelete. Should be 1/0 \n";
			$emptyDelete = intval(fgets(STDIN));
			if ($emptyDelete == 1 || $emptyDelete == 0) {
				break;
			}
		}
	}
	
	$cleaner = new Cleaner\FileCleaner($rootPathname, $emptyDelete);
	$cleaner->clearFolder();
	exit;
?>