'''
export VIDEO_FORMAT=NTSC
'''

import os
from subprocess import call
count = 0

def clear():
	os.system('clear')
	
def burner(image):
	os.system('growisofs -dvd-compat -Z /dev/sr0="' + str(image) + '".iso')
	
def calculator():
	var = raw_input('How many megabytes are desired? ')
	var1 = raw_input('How many minutes is the movie? ')
	if not var.isdigit() or not var1.isdigit():
		return
	var2 = ((int(var) * 8192) / (int(var1)*60)) - 256
	print var2
	
def author(movie):
	os.system(('mkdir "' + str(movie[:-4]) + '"_new'))
	os.system(('dvdauthor -o "' + str(movie[:-4]) + '"_new -t "'+ str(movie)+ '"'))
	os.system(('dvdauthor -o "' + str(movie[:-4]) + '"_new -T'))
	os.system(('genisoimage -dvd-video -o "'+ str(movie[:-4]) +'".iso "' + str(movie[:-4]) + '"_new'))
	os.system(('sudo rm -r "' + str(movie[:-4]) + '"_new'))

while True:
	count += 1
	if count == 1:
		print 'export VIDEO_FORMAT=NTSC\n\n'
	burn = '' ; video = '' ; option = '' ; var = ''		
	movie = raw_input('Enter the movie to convert; Type "burn" to burn image file; Type "author" to jump to authoring. ')
	if movie[0:2] == 'ls' or movie[0:3] == 'pwd':
		os.system(str(movie))
		continue
	if movie == 'clear':
		os.system('clear')
		continue
	if movie == 'burn':
		image = raw_input('What image would you like to burn? ')
		burner(image)
		continue
	if movie == 'author':
		movie = raw_input('What movie would you like to author? ')
		while burn not in ['y', 'n']:
			burn = raw_input('Burn (y/n) ')
		author(movie)
		if burn == 'y':
			os.system('growisofs -dvd-compat -Z /dev/sr0="'+ str(movie[:-4]) +'".iso')
		continue
	bit_question = raw_input('Use default bitrate (y/n) ')
	if bit_question != 'n':
		video = '6000k'
	if bit_question == 'n':
		while not video.isdigit():
			video = raw_input('Enter the desired video bitrate. Or (c) for calculator ')
			if video == 'c':
				calculator()
		video = str(video) + 'k'			
	while option not in ['y', 'n']:
		option = raw_input('Author file (y/n) ')
	if option == 'y':
		while burn not in ['y', 'n']:
			burn = raw_input('Burn (y/n) ')
	while var != 'go':
		var = raw_input('Type "go" ')
		
	new = str(movie[:-4]) + '_new.mpg'
	call(['ffmpeg', '-i', str(movie), '-filter:v', 'scale=\'w=min(720,trunc((480*33/40*dar)/2+0.5)*2):h=min(480,trunc((704*40/33/dar)/2+0.5)*2)\',pad=\'w=720:h=480:x=(ow-iw)/2:y=(oh-ih)/2\',setsar=\'r=40/33\'', '-target', 'ntsc-dvd', '-b:v', video, '-b:a', '256k', new])

	if option == 'y':
		break  
os.system(('mkdir "' + str(movie[:-4]) + '"_new'))

os.system(('dvdauthor -o "' + str(movie[:-4]) + '"_new -t "'+ str(movie[:-4]) + '"_new.mpg'))
os.system(('dvdauthor -o "' + str(movie[:-4]) + '"_new -T'))

os.system(('genisoimage -dvd-video -o "'+ str(movie[:-4]) +'".iso /home/jonathan/"' + str(movie[:-4]) + '"_new'))

if burn == 'y':
	os.system('growisofs -dvd-compat -Z /dev/sr0="'+ str(movie[:-4]) +'".iso')

os.system(('sudo rm -r "' + str(movie[:-4]) + '"_new'))
print 'Done'
 

