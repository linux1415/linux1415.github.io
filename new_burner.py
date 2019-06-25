#12-7-17

'''
export VIDEO_FORMAT=NTSC
'''
import sys, os
from subprocess import call
convert = 'no' ; author = 'no' ; burn = 'no' ; quality = '2'

def mp2(movie, video_bitrate, audio_bitrate, new_movie, quality):
	if video_bitrate != '5000k' or audio_bitrate != '192k':
		call(['ffmpeg', '-i', movie, '-filter:v', 'scale=\'w=min(720,trunc((480*33/40*dar)/2+0.5)*2):h=min(480,trunc((704*40/33/dar)/2+0.5)*2)\',pad=\'w=720:h=480:x=(ow-iw)/2:y=(oh-ih)/2\',setsar=\'r=40/33\'', '-target', 'ntsc-dvd', '-b:v', video_bitrate, '-b:a', audio_bitrate, new_movie])
	if video_bitrate == '5000k' and audio_bitrate == '192k':
		call(['ffmpeg', '-i', movie, '-filter:v', 'scale=\'w=min(720,trunc((480*33/40*dar)/2+0.5)*2):h=min(480,trunc((704*40/33/dar)/2+0.5)*2)\',pad=\'w=720:h=480:x=(ow-iw)/2:y=(oh-ih)/2\',setsar=\'r=40/33\'', '-target', 'ntsc-dvd', '-q:v', quality, '-q:a', '2', new_movie])

def author_file(author_folder, movie):
	folder = author_folder + '_folder'
	iso = author_folder + '.iso'
	call(['mkdir', folder])
	call(['dvdauthor', '-o', folder, '-t', movie])
	call(['dvdauthor', '-o', folder, '-T'])
	call(['genisoimage', '-dvd-video', '-o', iso, folder])
	call(['sudo', 'rm', '-r', folder])

def burner(iso):
	call(['growisofs', '-dvd-compat', '-Z', iso])

def calculator():
	var = raw_input('How many megabytes are desired? ')
	var1 = raw_input('How many minutes is the movie? ')
	if not var.isdigit() or not var1.isdigit():
		return
	var2 = ((int(var) * 8192) / (int(var1)*60)) - 192
	print 'Bitrate: ' + str(var2)

def info():
	print '\nAdd "convert" to transcode to mp2 format'
	print 'Add "author" to create an iso out of an mpg file'
	print 'Add "burn" to burn iso image to disk'
	print 'Add "all" to convert to mpg and then author to iso and then burn to disk'
	print 'Add "calc" for bitrate calculator'
	print 'Add "info" for information about video file'
	print 'Add "-a <desired audio bitrate>"; example: "-a 192"'
	print 'Add "-v <desired video bitrate>"; example: "-v 3000"'
	print 'Add "-q <desired quality setting>"; 2 is best; example: "-q 4"; quality settings override bitrate settings'
	print 'To change output folder, simply type in the desired path'
	print 'Example command: "python burner.py Desktop/video.mp4 -a 128 -v 2000 convert Desktop/folder"'
	print '\n'

video_bitrate = '5000k'
audio_bitrate = '192k'

arg = sys.argv
if len(arg) < 2:
	info()
	sys.exit()

if arg[1] == 'calc':
	calculator()
	sys.exit()

if os.path.exists(arg[1]) == False:
	info()
	sys.exit()

movie = arg[1]
del arg[0:2]

new_movie = os.path.basename(movie)
split_file = new_movie.split('.')
del split_file[-1]
new_movie = '.'.join(str(z) for z in split_file)
path = os.path.dirname(movie)

if 'info' in arg:
	call(['ffmpeg', '-i', movie])

if 'author' not in arg and 'burn' not in arg:
	convert = 'yes'

while len(arg) > 0:
	if arg[0] == 'convert':
		convert = 'yes'
		del arg[0]
		continue
	if os.path.exists(arg[0]) == True:
		path = arg[0]
		del arg[0]
		continue
	if arg[0] == 'info':
		del arg[0]
		continue
	if arg[0] == 'author':
		author = 'yes'
		del arg[0]
		continue
	if arg[0] == 'burn':
		burn = 'yes'
		del arg[0]
		continue
	if arg[0] == 'all':
		convert = 'yes'
		author = 'yes'
		burn = 'yes'
		del arg[0]
		continue
	if arg[0] == '-v':
		video_bitrate = str(arg[1]) + 'k'
		del arg[0:2]
		continue
	if arg[0] == '-a':
		audio_bitrate = str(arg[1]) + 'k'
		del arg[0:2]
		continue
	if arg[0] == '-q':
		quality = str(arg[1])
		del arg[0:2]
		continue
	if arg[0] == 'calc':
		calculator()
		sys.exit()
	else:
		print 'somethings not right...'
		info()
		sys.exit()

new_movie = os.path.join(path,new_movie) + '.mpg'

if convert == 'yes':
	mp2(movie, video_bitrate, audio_bitrate, new_movie, quality)

if author == 'yes':
	author_folder = new_movie[:-4]
	if convert == 'yes':
		movie = new_movie
	author_file(author_folder, movie)

if burn == 'yes':
	iso = '/dev/sr0=' + movie
	if author == 'yes':
		iso = '/dev/sr0=' + author_folder + '.iso'
	burner(iso)
	























