<?php

	namespace Cleaner;
	
	class FileCleaner{
		private $rootFolder = '';
		private $emptyDelete = 0;

		public function __construct(string $rootFolder, int $emptyDelete){
			$this->rootFolder = $rootFolder;
			$this->emptyDelete = $emptyDelete;
		}

		public function clearFolder(){
			$iter = new \RecursiveIteratorIterator(
		    	new \RecursiveDirectoryIterator($this->rootFolder, \RecursiveDirectoryIterator::SKIP_DOTS),
		    	\RecursiveIteratorIterator::CHILD_FIRST,
		    	\RecursiveIteratorIterator::CATCH_GET_CHILD
			);

			foreach ($iter as $path => $dir) {
			    if ($dir->isDir()) {
			    	$bakFiles = glob($path . "/*.bak");
			    	if (count($bakFiles) > 0) {
			    		foreach ($bakFiles as $bakFilePath) {
			    			//get filename
			    			$bakFileName = basename($bakFilePath, '.bak');
			    			//get all files with ".bak" name and exclude .bak file
			    			$filesByBakName = preg_grep('/'.$bakFileName.'\.bak$/', glob($path.'/'.$bakFileName.'*.*'), PREG_GREP_INVERT);
			    			if (count($filesByBakName) == 0) {
			    				//delete bak File
			    				unlink($bakFilePath);
			    			}
			    		}
			    	}

			    	//check is folder is empty
			    	$isDirEmpty = true;
			    	foreach (scandir($path) as $file) {
			    		if (!in_array($file, array('.','..','.DS_Store'))) {
			    			$isDirEmpty = false;
			    		}
			    	}		    	

			    	//Delete empty folders
			    	if ($isDirEmpty) {
			    		if ($this->emptyDelete == 1) {

			    			//Delete .DS_Store file
			    			$dirlist = scandir($path);
						    foreach($dirlist as $item){
						        if($item !='.' && $item !='..'){
					                if($item == '.DS_Store'){
					                    $filename = $path.'/'.$item;
					                    unlink($filename);
					                }        
						        }
						    }
			    			rmdir($path);
			    		}
			    	}
			    }
			}
			//clear root directory
			$bakFiles = glob($this->rootFolder . "/*.bak");
	    	if (count($bakFiles) > 0) {
	    		foreach ($bakFiles as $bakFilePath) {
	    			//get filename
	    			$bakFileName = basename($bakFilePath, '.bak');
	    			//get all files with ".bak" name and exclude .bak file
	    			$filesByBakName = preg_grep('/'.$bakFileName.'\.bak$/', glob($path.'/'.$bakFileName.'*.*'), PREG_GREP_INVERT);
	    			if (count($filesByBakName) == 0) {
	    				//delete bak File
	    				unlink($bakFilePath);
	    			}
	    		}
	    	}
		}
	}
?>