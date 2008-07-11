<?php
/**
 * MediaAttach
 *
 * @version      $Id: $
 * @author       Axel Guckelsberger
 * @link         http://www.guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/*
 * ---------------------------------------------------------------------------------------------------------
 * Popup selector for scribite plugin
 * based on mediashare implementation
 * ---------------------------------------------------------------------------------------------------------
 */

Loader::requireOnce('modules/MediaAttach/common.php');


/**
 * return array with supported providers for embedding external videos
 *
 * @return       array       provider array
 */
function MediaAttach_extvideoapi_getproviders()
{
    $providers = array();

    $providers[] = array('name' => 'Dailymotion',
                         'desc' => 'Dailymotion - Share Your Videos',
                         'domains' => array('dailymotion.com'),
                         'filetypes' => array('extension' => 'flv', 'mimetype' => 'application/x-shockwave-flash'),
                         'playerWidth' => 420,
                         'playerHeight' => 336,
                         'searchpattern' => array(
                                'titleStart' => '<h1 class="nav with_uptitle">',
                                'titleEnd'   => '</h1>',
                                'descStart'  => '<div class="description foreground">',
                                'descEnd'    => '</div>',
                                'fileStart'  => 'param name=&quot;movie&quot; value=&quot;',
                                'fileEnd'    => '&quot;&gt;&lt;/param&gt;&lt;',
                                'filePfix'   => '',
                                'fileSfix'   => ''));

    $providers[] = array('name' => 'Google Video',
                         'desc' => 'Google Video',
                         'domains' => array('video.google.com', 'video.google.de'),
                         'filetypes' => array('extension' => 'flv', 'mimetype' => 'application/x-shockwave-flash'),
                         'playerWidth' => 400,
                         'playerHeight' => 326,
                         'searchpattern' => array(
                                'titleStart' => '<title>',
                                'titleEnd'   => '</title>',
                                'descStart'  => '<meta name=\"description\" content=\"',
                                'descEnd'    => '\">',
                                'fileStart'  => 'videosendlink\', \'',
                                'fileEnd'    => '\' \+ \'',
                                'filePfix'   => 'http://video.google.com/googleplayer.swf?',
                                'fileSfix'   => ''));

    $providers[] = array('name' => 'YouTube',
                         'desc' => 'YouTube - Broadcast Yourself.',
                         'domains' => array('youtube.com', 'youtube.de'),
                         'filetypes' => array('extension' => 'flv', 'mimetype' => 'application/x-shockwave-flash'),
                         'playerWidth' => 425,
                         'playerHeight' => 355,
                         'searchpattern' => array(
                                'titleStart' => '<meta name=\"title\" content=\"',
                                'titleEnd'   => '\">',
                                'descStart'  => '<meta name=\"description\" content=\"',
                                'descEnd'    => '\">',
                                'fileStart'  => '&quot;&gt;&lt;param name=&quot;movie&quot; value=&quot;',
                                'fileEnd'    => '&quot;&gt;&lt;/param&gt;&lt;param name=&quot;',
                                'filePfix'   => '',
                                'fileSfix'   => ''));

/*

MySpace (http://www.myspace.com) - (Video and Music part)
hi5 - Who's in? (http://www.hi5.com) (Video part)
Image hosting, free photo sharing & video sharing at Photobucket (http://www.photobucket.com)
See it! Shoot it! Share it! - Easy at AOL Video (http://www.uncutvideo.aol.com)
Welcome to PerfSpot | PerfSpot Homepage | PerfSpot.com (http://www.perfspot.com)
Netlog (http://www.netlog.com) (facebox.com) (Video part)
Bebo (http://www.bebo.com) - (Video and Music part)
Multiply - Share your life with your friends (http://www.multiply.com)
Tagged (http://www.tagged.com)
Metacafe â¤? Best Videos & Funny Movies (http://www.metacafe.com)
MEGAVIDEO - I'm watchin' it (http://www.megavideo.com)
blip.tv (beta) (http://www.blip.tv)
Revver &#x00BB; (http://www.revver.com)
http://www.archive.org
Break.com - Free videos, pictures, and comedy for guys (http://www.break.com)
crunchyroll - feed your need! (http://www.crunchyroll.com)
Music Videos, Reality TV Shows, Celebrity News, Top Stories | MTV (http://www.mtv.com)
TV Shows, Movies, Music Videos and Clips-Search, Watch & Discuss - SideReel (http://www.sidereel.com)
TV.com: TV News - TV Shows - TV Listings - Entertainment News (http://www.tv.com)
Zedge: Free ringtones, free wallpaper, free themes, free downloads to Nokia and other mobile phones. (http://www.zedge.net)
Broadcaster.com | Home | Viral Video Clips, Live Community, News, Software, Movies, Music, Games, Mobile Media & More (http://www.broadcaster.com)
LiveVideo.com - The World is Watching (http://www.livevideo.com)
Buzznet - Community Music Blogs, Friends, Video Sharing, and Photo Sharing (http://www.buzznet.com)
IMEEM - what's on your playlist? (http://www.imeem.com)
Peekvid (http://www.peekvid.com)
LiveLeak.com - Redefining the Media (http://www.liveleak.com)
Ringo - Coole Leute. Coole Bilder. (http://www.ringo.com) (video part)
Free video clips and films at GoFish. Watch free funny video clips and more! (http://www.gofish.com)
SPIKE - Video, User Video, Movies, Trailers, Music and Viral Videos - SPIKE Powered By IFILM (http://www.ifilm.com) (SPIKE)
ESPN Video Beta (http://sports.espn.go.com/broadband/video/)
Putfile.com :: Free Media Hosting and More! (http://www.putfile.com)
American Idol: Official FOX Site (http://www.americanidol.com)
MojoFlix - New videos (http://www.mojoflix.com)
Porkolt.com - social network (http://www.porkolt.com)
Heavy.com - Videos, humor, community and other time-wasting tools (http://www.heavy.com)
Bullz-Eye.com - Guys' Portal to the Web (http://www.bullz-eye.com)
Home | The Onion - America's Finest News Source (http://www.theonion.com)
http://www.bolt.com
Maxim - Hot Girls, Sex, Sports, Games, Technology, Hotties, Maxim Magazine (http://www.maximonline.com)
Latest | gigglesugar - Funny Videos & Humor. (http://www.gigglesugar.com)
Funny video clips, funny movies, classic TV ads, virals, silly pictures - Kontraband (http://www.kontraband.com)
FileCabi.net - Where you Provide the Entertainment!! (http://www.filecabi.net)
http://www.vh1.com (Video and Music)
Crackle - Stream On (http://www.grouper.com)
Culture, Music Videos, News, Travel, Documentaries | VBS.TV (http://www.vbs.tv)
FLURL.com | The Best of Online Video (http://www.flurl.com)
http://www.tv-links.co.uk (%80 movies supported)
Stickam - The Live Community (http://www.stickam.com)
V:social: Online Video and Social Media Tools (http://www.vsocial.com)
GorillaMask.net: Killing Productivity, Monday-Friday (http://www.gorillamask.net)
Jokeroo.com - Funny Videos, Funny Pictures, Games, Entertainment and More! (http://www.jokeroo.com)
Brightcove - Internet TV Your Way (http://www.brightcove.com)
Online videos: From home videos to premium internet television content | Veoh Video Network (http://www.veoh.com)
Last.fm &ndash; The Social Music Revolution (http://www.last.fm)
SpikedHumor.com » Spiked Daily (http://www.spikedhumor.com)
Funny Videos, Crazy Videos, Video Clips :: Vidmax.com (http://www.vidmax.com)
Savvy.com (http://www.savvy.com)
glumbert - the most amazing videos on the internet (http://www.glumbert.com)
I Am Bored - Sites for when you're bored. (http://www.i-am-bored.com)
Free video hosting (http://www.vidilife.com)
Pyzam - MySpace Layouts, Flash Toys, Comments Graphics, Funny Pics and More! (http://www.pyzam.com)
FunnyJunk (http://www.funnyjunk.com)
Our Crap is Your Crap << totallycrap.com (http://www.totallycrap.com)
Vidiac.com (http://www.vidiac.com)
FHM Magazine Online - Mens Magazine (http://www.fhm.com)
Sifted Videos &bull; VideoSift: Online Video *Quality Control (http://www.videosift.com)
Str8Up (http://www.Str8Up.com)
WeakGame Entertainment - Online Entertainment Magazine, Video Hosting, Streaming Multimedia, Night Clubs (http://www.weakgame.com)
Yikers.com - Funny Videos, Pictures, Jokes, and Humor (http://www.yikers.com)
VIDEO CODE ZONE | 40,000+ Music Video Codes For MySpace, Piczo, Friendster and Xanga, Free Movie Trailers, Funny Clips & Gaming Videos, Online Webcam Chat (http://www.videocodezone.com)
http://www.uniquepeek.com
KillSomeTime.com - Funny Videos, Extreme Videos, Funny Movies, Flash Games, Funny Pictures (http://www.killsometime.com)
tetesaclaques.tv - Têtes à claques, clips d'animations humoristiques en ligne (http://www.tetesaclaques.tv)
Dumpalink.com - Your Daily Entertainment (http://www.dumpalink.com)
Neatorama (http://www.neatorama.com)
LiveDigital: Home (http://www.livedigital.com)
Vimeo. Because everyone shouldnâ¤?t see everything. (http://www.vimeo.com)
Cracked.com - America's Only Humor & Video Site, Since 1958 (http://www.cracked.com)
Bravo TV Shows: Fashion, Comedy, Celebrity and Real Estate Shows â¤? Official Bravo TV Site (http://www.bravotv.com)
http://www.thatvideosite.com

Yahoo! Video (http://www.video.yahoo.com)


Sweetcrazyboy SMS Jokes Fun, Shayari Site,Fun SMS,Cool SMS,Jokes SMS,Romantic SMS,Love SMS,Flirt SMS (http://www.sweetcrazyboy.com)
Bore Me - funny videos, pictures, games and jokes (http://www.boreme.com)
Fight Videos, UFC Videos, Street Fight Video Clips (http://www.wildko.com)
MachoVideo.com (http://www.machovideo.com)
Funny or Die - funny videos featuring celebrities, comedians, and you. (http://www.funnyordie.com)
Internet entertainment updated daily with videos, animations, games and pictures - YourDailyMedia.com (http://www.yourdailymedia.com)
Jack9 - unTV (http://www.jack9.com)
Watch and Win - WeWin Videos (http://www.wewin.com)
Slacker Network (http://www.slackernetwork.com)
RedBalcony.com - Movie Trailers, TV, DVDs, Videos, Funny Clips, Celebrities Videos, Photos and Games (http://www.redbalcony.com)
Shoutfile.com - Free videos, pictures, and comedy for everyone! (http://www.shoutfile.com)
DumbR (http://www.dumbr.com)
theYNC.com Daily Media, Humor, Shocking, News Videos (http://www.theync.com)
http://www.educatedearth.net
Funny Hub - Funny Pictures, Videos & Jokes (http://www.funnyhub.com)
Sharkle.com - Free Online Video Sharing Community (http://www.sharkle.com)
ø Extreme Videos ø (http://www.buzzhumor.com)
http://www.godtube.com
EJB.com: The best videos, pictures, and galleries on the web. (http://www.ejb.com)
Celebrity Videos, Hot Sexy Movie Clips, Funny Celebrity Gossip (http://www.vidking.com)
Retro Junk | Hey I remember that (http://www.retrojunk.com) (video part)
VMIX Video Sharing & Hosting Community - Watch & Share Funny Free Home Made Videos - Creative Is Sexy (http://www.vmix.com)
Videoegg - People powered media. (http://www.videoegg.com)
Myspace Layouts, myspace icons, halloween myspace layouts, myspace halloween layouts, myspace graphics, myspace comments, myspace codes, glitter graphics, funny pictures, poems, jokes, games, ecards, celebrities, myspace layout codes, funny videos, m (http://www.funmunch.com)
Funny Videos, Funny Pictures, DailyHaHa (http://www.dailyhaha.com)
VideoJug - Life Explained. On Film. (http://www.videojug.com)
- OwnageVideos.com - This site owns! Sexy & Owned Videos (http://www.ownagevideos.com)
EVTV1 - Experience The Difference - EVTV1 brings you the best and most diverse video clips. From history and news, to comedy and bizarre you can watch it all right here. (http://www.evtv1.com)
URTH.TV (http://www.urth.tv)
PSFIGHTS.com - Pure Street Fights Videos, Girl Fights, Kimbo Fights, Explosive Fights (http://www.psfights.com)
MilkandCookies - Community Moderated Funny Videos, Links and Dada (http://www.devilducky.com)
Original Series, Featured Artists & Funny Videos on Super Deluxe (http://www.superdeluxe.com)
Mental Funk - Funny Pics, Hot Flicks, and Stupid Antics (http://www.mentalfunk.com)
Funny Videos | Funny Movies | Funny Clips | Lemonzoo Entertainment (http://www.lemonzoo.com)
Funny Videos, Sexy Videos, Freaky Videos, Flash Games, Funny Jokes, Popular Videos (http://www.freaknfunny.com)
TumTube.com- Be Desi - Watch Desi, Free Desi Videos, Best Desi Videos, Cool Desi Videos (http://www.tumtube.com)
Best Week Ever (http://www.bestweekever.tv)
Funny Videos, Funny Clips, Funny Stuff, Crazy Videos, Funny Pictures (http://www.bofunk.com)
http://www.aniboom.com
TrickLife.com (http://www.tricklife.com)
Need For Fun (http://www.needforfun.com)
FunMansion - Funny Videos, Pictures, and Games (http://www.funmansion.com)
Chum Video - The Best Funny Videos on The Net - Updated Every Hour! (http://www.chumvideo.com)
Fugly.com - It's FUN! It's FREE! It's FUGLY! - funny videos, flash games, clean jokes, hilarious movies, funny pics, office jokes, free prizes, horrible horoscopes, hysterical chat pranks, chat scripts and much more! (http://www.fugly.com)
Funny videos, Sexy videos, Shocking videos and Fight videos - Clipjunkie.com (http://www.clipjunkie.com)
Expert Village: Free video clips, how to videos, and video instruction (http://www.expertvillage.com)
Funny Videos Collection of Funny Video Clips and Funny Movie Videos To Download (http://www.funny-videos.co.uk)
Castpost: Web Video Solutions (http://www.castpost.com)
Moron.com - Free Videos, Pictures, Games, And Comedy (http://www.moron.com)
Blogging Tips (http://www.cucirca.com)
Uber (http://www.uber.com)
Home - Too Shocking - Shocking Videos, Extreme Videos, Death Videos, Fight Videos (http://www.tooshocking.com)
Humor, videos de humor, videos divertidos, fotos, postales, animaciones, bromas, bromas pesadas (http://www.alcachondeo.com)
Free porn, nude girls, naked celebrities and hot chicks (http://www.uneaten.com)
Shocking Videos (http://www.shockinghumor.com)
http://www.vid2c.com
Main -- Resource for Extreme Internet entertainment updated daily with videos, games and pictures - Zaable.com (http://www.zaable.com)
Dorks - Funny Videos, Pictures, Games (http://www.dorks.com)
Current // Home (http://www.current.tv)
Top10Virals.com - 10 New Viral Videos Added Daily (http://www.top10virals.com)
Funny Videos Clips | Funny Commercials | Priceless Pictures at Smit Happens (http://www.smithappens.com)
Humping Frog - Daily updated funny videos, pictures, audio, games, jokes and comics! (http://www.humpingfrog.com)
Zuuble - Funny Videos, Fights, Fight Videos, Online Games (http://www.zuuble.com)
Funny Videos, Games, Animations, Pictures @ YO! FUN (http://www.yofun.net)
Nearly Good - funny videos, sexy babes, play games, fun pictures, jokes + more (http://www.nearlygood.com)
Free Movies & Documentaries - (incl. public domain) (http://www.jonhs.net/freemovies/)
Extreme Funny Humor (http://www.extremefunnyhumor.com)
PANDACHUTE.COM (http://www.pandachute.com)
Ourmedia: Homepage (http://www.ourmedia.org)
Danerd.com - Funny videos sharing community (http://www.danerd.com)
13gb.com Internet Goodness, Updated Daily (http://www.13gb.com)
Violent Puppy - Where Violence, Sex and Humor Make Demon Babies (http://www.violentpuppy.com)
Television 2.0 - Beba by N.I.X. and Ventura (http://www.web2.0television.com) (Web 2.0 Television)
Fight Dump - Fight Videos, Street Fights, UFC Fights, PRIDE Fights and Free Jiu Jitsu Training Videos (http://www.fightdump.com)
BestCrazyVideos.com - the best crazy videos (http://www.bestcrazyvideos.com)
Music Video Codes For Myspace Hi5 Bebo Facebook Piczo Offuhuge Html Music Codes - Free Music Video Codes Links Rock Dance Reggaeton Perreo Trance Pop Hip Hop Comedy Flash Game Codes Podcast Videos,Toronto NightClub Videos (http://www.offuhuge.com)
Collegeslackers.com - funny videos, forum, pictures, product reviews and more. (http://www.collegeslackers.com)
http://www.eefoof.com
Shizzville | Daily Updates of the Best Videos on the Internet! (http://www.shizzville.com)
Funny Videos,Funny Pictures,Free Games,Myspace,Sexy Videos, Hot Girls - Main (http://www.hosthumor.com)
Dumbie - Funny Videos, Funny Links (http://www.dumbie.com)
Very Funny Ads (http://www.veryfunnyads.com)
CBS.com - Innertube (http://www.cbs.com/innertube/)
Video Bomb - Front Page (http://www.videobomb.com)
Funny Videos, Funny Pictures and Flash Soundboards (http://www.mediabum.com)
ApeDump.com Humor And Entertainment Site (http://www.apedump.com)
videoSPUD.com | Funny Videos | Hot Videos | Crazy Videos (http://www.videospud.com)
7HUMOR - Safe Humor, Videos, Pics and Games (http://www.7humor.com)
Cool Stuff - the best place for funny, cool and sexy videos on the net! (http://www.c00lstuff.com)
Gkko.com - Funny Video Clips, Pictures, and Games Updated Every 2 Hours (http://www.gkko.com)
<Influks.com> Because you have nothing better to do! (http://www.influks.com)
Funny Videos, Funny Pictures (http://www.balagana.com)
MySpaceTV: Sieh dir deine Lieblingsvideos, -trailer, -filme, -TV-Serien, -musikvideos und -clips an, und lass andere daran teilhaben. (http://www.myspacetv.com)
2008 Dog Show - News, Events, Finalists, Dog Breeds & Awards - WestminsterKennelClub.org (http://www.westminsterkennelclub.org)
Photo & Video Sharing (http://www.pickle.com)
Stupid videos, Funny videos, Extreme videos - StupidVideos.us (http://www.stupidvideos.us)
Drunk University: Drunk girls, videos, and photos (http://www.drunkuniversity.com)
TonTuyau.com - La communauté de vidéo au Québec ! (http://www.tontuyau.com)
Vidly - Your daily video entertainment. (http://www.vidly.net)
Welcome to Don and Murph.com- The Funniest Internet Show Anywhere!! (http://www.donandmurph.com)
Welcome to Kewego - Home page - Kewego (http://www.kewego.com)
ThorLinks.com! The Best Place For Your Daily Dosage Of Fun! (http://www.thorlinks.com)
eVideoShare (http://www.evideoshare.com)
Crack Muffin - Tasty Entertainment Everyday! (http://www.crackmuffin.com)
Home|Celebrity Videos,Celebrity News,Celebrity Photos,Funny Videos,Funny Pictures,myspace backgrounds (http://www.needlaugh.com)
Falarious Media - Funny Videos | Funny Movies | Funny Video Clips | Cool Videos| Flash Cartoons| Funny Pictures| Funny Videos| Games | Shocking Videos| Text | MySpace Codes (http://www.falarious.com)
NO GOOD TV - Putting the F-U back into FUN (http://www.ngtv.com) (new)
Lulu TV (http://www.lulu.tv)
Funny Pictures Videos Flash Games Cartoons Prank Calls (http://www.media-post.net)
Funny Videos, Funny Pictures, Flash Games, Crazy Movies, Funny Jokes (http://www.plsthx.com)
TacoBomb - Funny videos, flash games, funny pictures, jokes and animations. (http://www.tacobomb.com)
Retrovision TV (http://www.retrovision.tv)
Best of Google Video (http://www.bestofgooglevideo.com)
FunnyBurger.Com - Funny Games - Hilarious Videos - Funny Pics & More (http://www.funnyburger.com)
http://www.vume.com
http://www.liveforfun.org
RGX LIFE | Sponsored by RGX Bodyspray (http://www.rgxlife.com)
The Shortest Bus - Free Funny Video Clips, Free Flash Games, Funny Pictures & More! (http://www.theshortestbus.com)
American Films (http://www.americanfilms.com)
Funny Videos, pictures, babes, clips, comedy, movies (http://www.funnyvids.com)
ZanyVideos.com - Funny Videos, Free Videos, Hot Videos and more! (http://www.zanyvideos.com)
DailySlacker.com - College Videos, Funny Videos, Funny Pictures (http://www.dailyslacker.com)
BreakTaker - funny movies ? funny videos ? funny photos and online games (http://www.breaktaker.com)
Funny web zone (http://www.funnywebzone.com)
Video Clips Dump - Funny Videos, Funny Video Clips, Funny Clips (http://www.videoclipsdump.com)
Funny Videos, Funny Video Clips, Funny Pictures - GooglyFoogly.com (http://www.googlyfoogly.com)
Funny videos, Fight videos and crazy viral videos. Myspace Video codes for Crazy and funny videos, Quizes, surveys and much more along with the rest of the internet garbage (http://www.clumzy.com)
Chris and Sam | Something Fun Everyday (http://www.chrisandsam.com)
OWNED.COM - Owned Videos / Vids (http://www.owned.com)
Fightzilla.com - Uncensored Fight Videos, Babes Fighting, UFC Videos, Real Street Fight Video Clips (http://www.fightzilla.com)
Funny Videos and Clips | Media updated Daily (http://www.first-ward.com)
TeacherTube - Teach the World (http://www.teachertube.com)
TheWebDump - New Videos and Links added every 10mins! (http://www.thewebdump.com)
TheTartCart.com - Killing Brain Cells One Day At A Time (http://www.thetartcart.com)
Nopers! - Just watch it! (http://www.nopers.com)
Medialunchbox - Funny Videos, Games and Other Funny Junk (http://www.medialunchbox.com)
GeeVee - Share Yours. (http://www.geevee.com)
The Best Funny and Free Viral Videos - Updated Daily! - VidFan (http://www.vidfan.com)
Free Picture and Video Sharing and Upload | Share your pictures and videos online at Pixparty.com (http://www.pixparty.com)
Jokeroo.com - Funny Videos, Funny Pictures, Games, Entertainment and More! (http://www.jokaroo.com)
Funatico - Funny Video Clips, Funny Pictures, Funny Videos (http://www.funatico.com)
JustViralVideos.com - viral and funny videos (http://www.justviralvideos.com)
Funny Stuff | The best place for online entertainment! (http://www.fuhnee.com)
LOLWOW.com - Laughing out Loud, Wow! (http://www.lolwow.com)
TVO.ORG HOME (http://www.tvo.org)
Zyped! - Diggin' up the good stuff. (http://www.zyped.com)
Really Funny Clips - Your source for free online funny video clips. (http://www.reallyfunnyclips.com)
Funny Videos, Addicting Games, Funny Clips (http://www.monkeybriefs.com)
Funny Movies | Free funny movies, funny videos, fun movies. (http://www.funnymovies.net)
http://www.thatlitevideosite.com
Priceless Funny Videos - commercials - funny video clips - daily (http://www.pricelessfunnyvideos.com)
AT&T Home Turf (http://www.seehowtheylive.com)
The Daily Top 10 (http://www.dailytop10.net)
Plicks - Best myspace videos, games & images. (http://www.plicks.com)
Funny clips, funny movies, funny videos - FrozenHippo.com (http://www.frozenhippo.com)
DailyDumb.com - Dumb People, Dumb Games, Dumb Pictures, Dumb Videos, Funny pictures, Flash Games (http://www.dailydumb.com)
Evil Humor - That's Not Funny (http://www.evilhumor.com)
Dump4Links.com - Funny Videos, Sexy Clips - All Videos (http://www.dump4links.com)
Radioactif.tv | Mon Espace Vidéo, Audio, Photo et Texte au Québec, 100% gratuit! Grosse journée au bureau Vidéo (http://www.radioactif.tv)
Disloyal.org - MySpace Videos - Pictures and Codes for MySpaces - Funny Videos - Free Flash Games (http://www.disloyal.org)
Upload, Share, Earn and Connect Videos - Qweki.com (http://www.qweki.com)
College After Hours - What to do when class is over! (http://www.collegeafterhours.com)
Funny Videos, Funny Clips, News and Celebrity Gossip (http://www.bigbadblob.com)
9 Incher - Entertainment Media Index - Videos, Pictures, Games and Animations Updated Hourly (http://www.9incher.com)
Hot Celebrity Videos - Main (http://www.myvideoshost.com)
Diptard.com - Funny Videos, pictures, babes, fights, clips, comedy, movies (http://www.diptard.com)
Blennus - your driveling idiot (http://www.blennus.com)
Funny linkdump >> the best link dump >> Crazy Video Compilation and Funny Bloppers (http://www.funny-linkdump.com)
Free Videos, funny Pictures, Funny Crazy Sexy Videos, flash Games, cartoons, animations, Free media Rss feed (http://www.videolots.com)
Bloogie - Funny Videos - Movies - Pictures (http://www.bloogie.com)
God of Humor (http://www.godofhumor.com)
FileCrush: Funny Videos, Funny Movies, Funny Video Clips (http://www.filecrush.com)
shock THIS! Shocking videos, war, accidents and more! (http://www.shockthis.com)
VidsCrazy.com Funny Weird and Shocking Videos and Celebrity Clips (http://www.vidscrazy.com)
http://www.evildump.com
Browse Files! - browse funny files, videos & images - free file host - browsefile.com (http://www.browsefile.com)
Slackerland (http://www.slackerland.com)
GeekyZeeks.com - Free Web Media Dump! (http://www.geekyzeeks.com)
Hot Movies (http://www.jumbosized.com)
GigglePlatter - Viral Funny Videos (http://www.giggleplatter.com)
Ridiculous Videos -- Your Daily Dose of Ridiculous Clips (http://www.ridiculousvideos.com)
The New York Times - Breaking News, World News & Multimedia (http://www.nytimes.com) (only video part)
Funny Videos | Stupid Videos Clips (http://www.feelstupid.com)
Video Sites - SkillTip.tv - Hosted Video Clips (http://www.skilltip.tv)
TV4u - Your source for online classic television (http://www.tv4u.com)
Martial Arts Videos ! (http://www.martialartclips.net)
http://www.madhousevideos.com
Cobalt Flash - Main Page (http://www.cobaltflash.com)
Vindie Online Channel Guide (http://www.vindie.com)
Funny Videos (http://www.loogon.com)
Home - Video Clipped (http://www.videoclipped.com)
Ryno Sauce (http://www.rynosauce.com)
MoreFunnyVideos.com - Only the funniest videos on the internet!! (http://www.morefunnyvideos.com)
OTube.ca Okanagan Video Sharing - Share Your Videos (http://www.otube.ca)
Day Zero | a feature film (http://www.dayzeromovie.com)






Nicht Englische Video Webs:

http://www.video.baidu.com
http://www.v.cctv.com
http://www.games.sina.com.cn/bn/
http://www.video.sina.com.cn
Das beste von Dada.net, Deutschland (http://www.dada.net)
Mail.Ru: (http://www.video.mail.ru)
Friendster - Home (http://www.friendster.com)
Video - INTERIA.PL - Å¨mieszne filmiki, filmy, reklamy, teledyski (http://www.video.interia.pl)
(http://www.tudou.com)
http://www.vlog.17173.com
(http://www.vzhangmen.com)
56.com (http://www.56.com)
123video - Grootste online video site van Nederland (http://www.123video.nl)
http://www.v.wangyou.com
(http://www.tv.mofile.com)
Trilulilu - Video, Imagini, Audio (http://www.trilulilu.ro)
(http://www.pomoho.com)
 (http://www.5show.com)
 (http://www.ouou.com)
(http://www.v.iask.com)
http://www.happy.enet.com.cn
ROFL.TO : Daily Funny Video Clips! (http://www.rofl.to)
Lustige Videos, Video Clips und Werbespots gibts bei uns - MyVideo (http://www.myvideo.de)
TVix.cn (http://www.tvix.cn)
 (http://www.yoqoo.com)
 (http://www.ku6.com)
 (http://www.6.cn) (6rooms.com)
UUME.COM - (http://www.uume.com)
http://www.163888.net
(http://www.vbox7.com)
Wrzuta.pl (http://www.wrzuta.pl)
A1 Bollywood Hindi Tamil Telugu Indian Movie Songs Music Videos - SmasHits.com (http://www.smashits.com)
(http://www.megajoy.com)
SantaBanta Homepage : Jokes, Wallpapers, Bollywood, e-cards and more (http://www.santabanta.com)
FLIX ? (http://www.flix.co.il)
Mean Duck | ohnoes, ohnoes, ohnoes. (http://www.meanduck.com)
ücretsiz Video Paylaþým Sitesi (http://www.izlesene.com)
Lustige Videos - Gratis Fun Video - Deine funny Videos bei Clipfish (http://www.clipfish.de)
GUBA - Enjoy, upload, and share free videos. Download hit movies and television shows (http://www.guba.com)
(http://www.youku.com)
LoadUp - (http://www.loadup.ru)
sevenload | The media platform for photos and videos (http://www.sevenload.com)
(http://www.podlook.com)
Ordena y comparte tus vídeos - www.dalealplay.com (http://www.dalealplay.com)
www.mmxxdd.com (http://www.mmxxdd.com) (video part)
Pikniktube (http://www.pikniktube.com)
Bienvenue sur Wideo - Accueil - Wideo (http://www.wideo.fr)
videogaga.lv - ir ko paskatÄ«ties! - (http://www.videogaga.lv)
SeeHaHa (http://www.seehaha.com)
Lustige Videos, witzige Flashgames und funny Werbespots auf chilloutzone.de (http://www.chilloutzone.de)
http://www.streamdump.com
eblogx.de - fun trash entertainment (http://www.eblogx.de)
WAT TV - (http://www.wat.tv)
http://www.carcrimes.com
(http://www.biku.com)
Music Videos at their best @ KOvideo.net (http://www.kovideo.net)
ICHLACHE.com » Fun-Blog (http://www.ichlache.com)
TN.com.ar (http://www.tn.com.ar)
Fun-Portal, Funlinks, Fun, Fun Videos, Fun Pics, lustiges Ebay, Games - bildschirmarbeiter.com (http://www.bildschirmarbeiter.com)
Hans-Wurst.de - Der tägliche Blödsinn des Internets (http://www.hans-wurst.de)
=) sinn-frei.com - fun-blog » lustige videos, witzige games & funny flashs (http://www.sinn-frei.com)
Jeuxvideo.TV : (http://www.jeuxvideo.tv)
Cool-Clip.de - FUN Spaß und coole VideoClips (http://www.cool-clip.de)
VideoWebTown.com - Free Video Hosting and Streaming Service (http://www.videowebtown.com)
Trendhure.com (http://www.trendhure.com)
My Cool Clips (http://www.mycoolclips.com)
(http://www.ourdv.com)
Vid Crazy - Home (http://www.vidcrazy.com)
http://www.movies.yoyos-blog.com
Eylol - Die Spaß-Community & Funseite mit attraktiven Prämien - Täglich neue Fun Videos, Bilder, Clips und vieles mehr! (http://www.eylol.de)
NSFW.to | Daily Entertainmet - Fun, Videos, Picture, Babes, Amateure and the best Trash! (http://www.juckiq.de)
STUPIDEXE.COM - Video divertenti e di particolare interesse, giochi flash, animazioni, sfondi e molto altro... (http://www.stupidexe.com)
http://www.autoclips.net
(http://www.totv.com.cn)
Funny-Media.org (http://www.funny-media.de)
http://www.fettemama.org
Lachlabor - Lustige Videos, Fun & witzige Bilder! (http://www.lachlabor.de)
Clips4.Us (http://www.clips4.us)
HIPHOPDEAL - LE HIP HOP EST AVANT TOUT UNE PASSION (http://www.hiphopdeal.com)
SomeHoney - Your collection of media (http://www.somehoney.com)
Crazy-Movie.de - Immer die neuesten Brüller (http://www.crazy-movie.de)
ClipTubes - Viral Videos (http://www.cliptubes.com)
Bienvenue sur VidÃ©oRigolo, le site gratuit de la vidÃ©o d'humour rigolo, vidÃ©os de gag, bÃªtisiers, chutes, blonde, etc. (http://www.videorigolo.com)
» Spassfabrik - Babes, lustige Bilder, coole Clips, Flash Games, Witze und Kurioses. Just Fun! (http://www.spassfabrik.net)
Tussi Clips - witzige Videos, Flash und scharfe Tussis (http://www.tussi-clips.de)
Paradise Philippines - Viral Videos (http://www.dalipit.com)
Funny-Fresh (http://www.funny-fresh.de)
eingeparkt.com - hier hat der spass eingeparkt (http://www.eingeparkt.de)
Funny-Shit.net » Fun Videos, Lustige Videos, Fun Clips, Witzige Filme, Funny Movies, Musik Clips (http://www.funny-shit.net)
Vidéo Humour gratuit, Videoclip et autres vidéos - Partager vos vidéos sur Tonclip.com (http://www.tonclip.com)
2funny4u - Der Linkdump: Funvideos, Fungames, Funpics, Hot babes (http://www.2funny4u.de)
Sexy Fun-Videos und Fun-Pics! (http://www.totaler-fun.de)
Trashbook.de - Lustige Videos, Bilder, Spass und viel zum Lachen (http://www.trashbook.de)
3steg.com - Your funny media center (http://www.3steg.com)
search 1 on :: search1on.com (http://www.extremesportsclips.net)
Top Free Music Downloads - free music news, music video downloads, free music download, celebrity photo, music charts, music lyrics, free ringtones (http://www.topfreemusicdownloads.com)
KrankerFrank - Präsentiert dir jeden Tag den BESTEN Funstuff! LayerFREI! Next door Nikki, Raven Riley ... (http://www.krankerfrank.com)
Total Blogal - SpaÃ¾ Blog (http://www.totalblogal.net)
http://www.myvideo.ge
http://www.see.daum.net
http://www.aura.damoim.net

*/


    return $providers;
}
