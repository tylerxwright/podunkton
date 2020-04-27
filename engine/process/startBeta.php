<?php
	global $database;
	global $session;
	global $core;
	global $msgObj;
	
	$result = $database->db_query("SELECT email, code FROM Beta");
	while($row = mysqli_fetch_object($result)) {
		$to = $row->email;
		
		$headers = "From: admin@podunkton.com" . "\r\n" . 
				   "Reply-To: vallosdck@gmail.com" . "\r\n".
				   "X-Mailer: PHP/" . phpversion();
				   
		$subject = "Welcome to Podunkton Closed Beta!";
		
		$message = "Welcome to Podunkton Closed Beta!\n\n" .
				   "Because of your interest in our new website and because you signed up, you are now " .
				   "invited to our closed beta! Beta is not an easy going process, we need people to play " .
				   "the site, work though it, explore, find bugs, everything and anything you can do. As a " .
				   "reward for your time spent helping us make this site all that it can be, we will be " .
				   "giving your live account (when we go live) lots of little suprises that only you, the ".
				   "beta users will recieve.\n\nAll you need to do now is click the link below or paste it ".
				   "into your browser and you will be sent into registeration. Once you've registered, your ".
				   "link will no longer be valid and you will have to go to http://www.podunkton.com to log in.".
				   "Here is your unique link : \n\nhttp://www.podunkton.com/betaregister/".$row->code." \n\n".
				   "We hope you have fun testing our site and if you spot any problems, be sure to report them ".
				   "using the error reporting link at the top of all pages.\n\nAlso one final detail! We are only ".
				   "testing Firefox and IE7 although IE7 is a bit slow. Safari also seems to work fine.\n\nHERE ARE YOUR TESTING GUIDELINES!\nIf you want to try to drop a table, be sure to drop the table called Destroy_Me. Any php injections are only allowed to user <?php echo 'steve'; ?>. HTML, just use <b></b>. As for other hacks, please don't destroy the beta site! Remember, we are testing here and finding one problem that kills everything prevents us from finding other problems. Use smart judgement when hacking because destroying the site will only prolong beta! We are going to be in California until the 29th, and I will be checking the site when I can to see how things are going.\n\nThank you again for your interest and with your help, we can make podunkton a reality! Below Jordan said something so check that out. By the way, my name is Tyler Wright.\n\n".
				   "Jordan: Well, its finally begun! Closed Beta is now up and running. If you've received this email, it means we're counting on you to test our partial site to the best of your ability. Log on as often as you can, feel free to have fun and use the forums to chat, but also try to test some of the features specifically according to what Tyler needs tested. We like to think that its a great opportunity to be the first on our going-on-2-year dream realized, but its also a big responsibility, since you are the only ones we have between now and full open beta launch to make sure we didn't leave something important out.\n\n".
				   "Most of you I've talked to before, so I know you'll do a good job. Some of you, this is our first REALLY getting to know each other, so lets do our best to make everything go well. We don't intend to block anyone from the closed beta, but please, stick to the guidelines Tyler has and don't go testing some hack unless directed to do so. Tyler will fill you in on more of that.\n\n".
				   "What I'm gonna need from everyone is suggestions, comments, and any questions about content, items, layout, and style. While I'm not going to be able to make a lot of changes at this point, we will take into consideration all of your opinions and concerns which may lead to future changes and development. So, yeah, if you have an idea for an item, item set, hairstyle, or something totally awesome for the website, fill me in. OH, and please do all of this in the thread specified. I'm not gonna be able to read a bunch of emails, but if you post it in the threads in the forums, I'll definately have time to scour those.\n\n".
				   "Another big help that I ask of you guys is to take screenshots, put your characters in your profiles on other sites, show your friends, make web banners, etc. ADVERTISE AT YOUR OWN WILL! We're totally cool with you making cartoons, music, youtube videos, art, drawings, etc. Some of it will probably be featured on the home page so other non-beta users can see what you're all doing. Again, this is not a requirement, but you're basically the biggest help we've got, so I'm counting on you all to help as much as you can. Don't worry, we'll get you some extra Munniez or something. Maybe some Credits and free items. I promise, good things!\n\n".
				   "Ok, another thing: Everything you do will be lost after closed beta EXCEPT YOUR CHARACTER AND ACCOUNT. We'll save those for you, so you et first dibs on names and so forth. We will have to remove all your items and munniez earned, but in return you'll get some pretty sweet bonuses for testing. I'll fill you in on all that later in the beta. YOU 'BETA' BE READY!\n\n".
				   "Many thanks and much love to you all for the help. It should be a pretty interesting few weeks, and I look forward to getting to know you all better. See ya in Podunkton!";
		
		mail($to, $subject, $message, $headers);
	}
	
	$msgObj->setMsg("BETA HAS BEEN STARTED!!!");
	header("Location: /admin/beta");
	
?>