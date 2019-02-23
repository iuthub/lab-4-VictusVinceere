<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Music Viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="http://www.cs.washington.edu/education/courses/cse190m/09sp/labs/3-music/viewer.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<div id="header">

			<h1>190M Music Playlist Viewer</h1>
			<h2>Search Through Your Playlists and Music</h2>
		</div>
		
		
		<div id="listarea">
			<ul id="musiclist">

				<?php
				$playlist = $_REQUEST["playlist"];
				if (isset($playlist) == false)
				{ 
					$files = glob("songs/*.mp3");
					$shuffle = $_REQUEST["shuffle"];
					$bysize = $_REQUEST["bysize"];
					if (isset($shuffle) == true)
					{
						shuffle($files);
					}
					if(isset($bysize) == true)
					{
						$files = filesSortBySize($files);
					}
					for ($i = 0; $i < count($files); $i ++) { 
						$filename = basename($files[$i]);
						$filesize = filesize($files[$i]);
						if ($filesize >= 0 && $filesize <= 1023) 
							$filesize = $filesize . " b";
						else if ($filesize >= 1024 && $filesize <= 1048575)
							$filesize = round($filesize / 1024, 2) . " kb";
						else
							$filesize = round($filesize / (1024 * 1024), 2) . " mb";
				?>
						<li class ="mp3item">
							<a href="<?= $files[$i] ?>"><?= $filename ?></a>
							(<?= $filesize ?>)
						</li>
					<?php
					}
					?>

					<li>
						<a href="music.php?shuffle=on">Shuffle</a>
					</li>

					<li>
						<a href="music.php?bysize=on">BySize</a>
					</li>

					<?php
					$files = glob("songs/*.m3u");
					for ($i = 0; $i < count($files); $i ++){
						$name = basename($files[$i]);
					?>
						<li class="playlistitem">
							<a href="music.php?playlist=<?= $name?>"><?= $name ?></a>
						</li>
					<?php
					}
						
				}
				else
				{
					$files = file("songs/" . $playlist, FILE_IGNORE_NEW_LINES);
					for ($i = 0; $i < count($files); $i ++)
					{
						if ($files[$i] [0] == '#') continue;
						$filesize = filesize("songs/" . $files[$i]);
						if ($filesize >= 0 && $filesize <= 1023) 
							$filesize = $filesize . " b";
						else if ($filesize >= 1024 && $filesize <= 1048575)
							$filesize = round($filesize / 1024, 2) . " kb";
						else
							$filesize = round($filesize / (1024 * 1024), 2) . " mb";
					?>
						<li class="mp3item"/>
							<a href="songs/<?=$files[$i]?>"><?=$files[$i]?></a>
							(<?= $filesize?>)
						</li>

					<?php
					}
					?>

					<li>
						<a href="music.php">Back</a>
					</li>

				<?php
				}
				?>

			</ul>
		</div>

<?php
function filesSortBySize ($files)
{
	$filesize = array();
	for ($i = 0; $i < count($files); $i ++)
	{
		array_push( $filesize , filesize($files[$i] ) );
	}
	
	for ($i = 0; $i < count($files); $i ++ )
	{
		for ($j = 0; $j < count($files) - 1; $j ++ )
		{
			if ($filesize[$j] < $filesize[$j + 1] )
			{
				$temp = $filesize[$j];
				$filesize[$j] = $filesize[$j + 1];
				$filesize[$j + 1] = $temp;
				$temp = $files[$j];
				$files[$j] = $files[$j + 1];
				$files[$j + 1] = $temp;
			}
		}
	}
	return $files;
}
?>


	</body>
</html> 