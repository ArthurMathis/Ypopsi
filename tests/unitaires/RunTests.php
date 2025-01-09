<?php 

require_once("TestsMoments.php");
(new TestsMoments())->run();

require_once("TestsUsers.php");
(new TestsUsers())->run();

require_once("TestsCandidates.php");
(new TestsCandidates())->run();