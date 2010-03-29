Version history:

3.1.2
-----
- compatible with the new ConnectionProvider and URLResolver API

3.1.1
-----
Fixes:
- calling closeBuffering() after the audio had finished caused an exception

3.1.0
-----
- compatibility with core 3.1 StreamProvider interface

3.0.4
-----
- fixed to stop audio when stop() is called

3.0.3
-----
- changed to recalculate the duration until the end of the file has been reached,
  this is needed to correctly estimate the duration of variable bitrate MP3's 

3.0.2
-----
- dispatches the LOAD event when initialized (needed for flowplayer 3.0.2 compatibility)
- fixed crashes of Mac  Safari when navigating out of a page that had a playing audio

3.0.1
-----
- First public beta release
