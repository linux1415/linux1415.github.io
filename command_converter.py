#12-1-17
#add "calc" for bitrate calculator; add "info" for information about file
#add resolution to change defaults; add desired bitrate as integer to change bitrate
#add copy to only change extension and not transcode codecs
#add a relative or absolute path to change output directory; to rename file, simply input the desired filename
#sample command: python converter.py Desktop/blessings.mp4 avi 1000 480x320
#sample command: python converter.py Desktop/blessings.mp4 info calc
#sample command: python converter.py Desktop/blessings.mp4 mp3 Desktop/ laura_story_blessings 256
#sample command: python converter.py Desktop/vikings.mkv mp4 copy

import os, os.path, sys
from subprocess import call
commands_list = sys.argv
list = []
possible = ['calc', 'info', '1080x720', '720x480', '480x320', 'copy']
formats = ['mp4', 'avi', 'mp3', 'mkv']
resolution = ''
bitrate = ''
same_quality = '-q:v 2'

def info():
	print '\nadd "calc" for bitrate calculator; add "info" for information about file'
	print 'add the desired resolution (1080x720 or 720x480 or 480x320) to change defaults; add desired bitrate as integer to change default bitrate'
	print 'add "copy" to only change extension and not transcode codecs'
	print 'add a relative or absolute path to change output directory; to rename file, simply input the desired filename'
	print 'sample command: python converter.py Desktop/blessings.mp4 avi 1000 480x320'
	print 'sample command: python converter.py Desktop/blessings.mp4 info calc'
	print 'sample command: python converter.py Desktop/blessings.mp4 mp3 Desktop blessings_laura_story 256'
	print 'sample command: python converter.py Desktop/vikings.mkv mp4 copy\n'

def h264(file, resolution, bitrate): #converts video file to mp4
	os.system(('ffmpeg -y -i "' + str(file) + '" -c:v libx264 -preset veryfast'+ str(resolution) +' ' + str(bitrate) + ' -pass 1 -c:a libmp3lame -b:a 192k -f mp4 /dev/null && \
ffmpeg -i "' + str(file) + '" -c:v libx264 -preset veryfast'+ str(resolution) + ' '+ str(bitrate) +' -pass 2 -c:a libmp3lame -b:a 192k "' + os.path.join(path,new_file) + '"_new.mp4'))

def avi(file, resolution, bitrate, same_quality): #converts video file to avi
	os.system(('ffmpeg -i "' + str(file) + '" '+ str(same_quality) +''+ str(resolution) +' ' + str(bitrate) + ' -c:v mpeg4 "' +  os.path.join(path,new_file) + '"_new.avi'))

def container_converter(file, container): #changes file extension
	os.system(('ffmpeg -i "' + str(file) + '" -c:a copy -c:v copy "' + os.path.join(path,new_file) + '"_new.' + str(container)))

def mp3(file, bitrate): #converts to mp3
	os.system(('ffmpeg -i "' + file + '" -c:a libmp3lame ' + bitrate + ' "' + os.path.join(path,new_file) + '".mp3'))

def check_res(a): #checks to see if the resolution was indicated in the command line input
	global resolution
	if a in ['1080x720', '720x480', '480x320']:
		resolution = ' -s ' + a

def calculator():
	var = raw_input('How many megabytes are desired? ')
	var1 = raw_input('How many minutes is the movie? ')
	if not var.isdigit() or not var1.isdigit():
		return
	var2 = ((int(var) * 8192) / (int(var1)*60)) - 192
	print 'Bitrate: ' + str(var2)

def con(): #makes sure user is ok with continuing
	for x in list:
		if x in formats:
			input = raw_input('\nContinue? (y/n) ') 
			print '\n'
			if input != 'y':
				sys.exit()


if len(commands_list) < 2: #exit if there is no input
	print 'No Input'
	info()
	sys.exit()

if commands_list[1] == 'calc': #displays calculator without file being specified
	calculator()
	sys.exit()

file = commands_list[1]
if os.path.exists(file) == False: #exit if path does not exist
	print 'Path does not exist'
	info()
	sys.exit()

new_file = os.path.basename(file) #deleting the extension from the file
split_file = new_file.split('.')
del split_file[-1]
new_file = '.'.join(str(z) for z in split_file)
path = os.path.dirname(file)


if len(commands_list) > 2: #puts input after the file in a list
	for x in commands_list[2:]:
		list.append(x)

for x in list: #makes sure there is no unexpected input
	if x not in formats and x not in possible and x.isdigit() == False and os.path.exists(x) == False:
		var = raw_input('Rename ' + new_file + ' to ' + str(x) + '? (y/n) ') #ask to rename file with unexpected input
		if var == 'y':
			for z in x:
				if z == '/':
					print 'Incorrect filename: no backslashes allowed'
					sys.exit()
			new_file = str(x)
			break
		print 'Incorrect Input'
		info()
		sys.exit()

if 'info' in list:
	call(['ffmpeg', '-i', file])
if 'calc' in list:
	calculator()

con()

for x in list: #checks to see if output path was changed by user
	if os.path.exists(x) == True:	
		path = x

if 'copy' in list: #changes extension but does not convert codecs
	for x in list:
		if x in formats:
			container_converter(file, x)
	sys.exit()

if 'mp4' in list: #converts video to mp4
	bitrate = '-b:v 1000k'
	for x in list:
		if x.isdigit():
			bitrate = (('-b:v ' + str(x) + 'k'))
		check_res(x)
	h264(file, resolution, bitrate)

if 'avi' in list: #converts video to avi
	for x in list:
		if x.isdigit():
			same_quality = ''
			bitrate = (('-b:v ' + str(x) + 'k'))
		check_res(x)
	avi(file, resolution, bitrate, same_quality)

if 'mp3' in list: #converts file to mp3
	for x in list:
		if x.isdigit():
			bitrate = (('-b:a ' + str(x) + 'k'))
	mp3(file, bitrate)
























	
