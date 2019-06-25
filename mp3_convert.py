#12-5-17
#sample command: python mp3_convert.py Desktop/test skip mp4 192 ; python mp3_convert.py Desktop/cd all 256
#option "all" converts all files in folder; option "skip" skips files with non-audio extensions
#to change bitrate, type in desired bitrate; to include a format automatically, type in format extension
import os, os.path, sys
from subprocess import call
arg = sys.argv
formats = ['m4a', 'webm']
arguments = ['all', 'skip']
possible_formats = ['mp4', 'mkv', 'avi', 'flv', 'mp3', 'ac3', 'aac', 'mp2']
list = ['mp4', 'mkv', 'avi', 'flv', 'mp3', 'ac3', 'aac', 'mp2', 'all', 'skip']
var2 = 0
bitrate = '192k'

def info():
	print 'Incorrect Input\n\nUse option "skip" to skip all non-audio files without asking.\nUse option "all" to convert all files.'
	print 'To include another media format in conversion, type in the format extension.\nTo change bitrate, simply type in the desired number.'
	print 'Examples: "python mp3_convert.py Desktop/test skip mp4" ; "python mp3_convert.py Desktop/test mp4 192"\n'
	sys.exit()

if len(arg) < 2:
	info()

var = sys.argv[1]
if var[-1] == '/':
	var = var[:-1]

new_folder = var + '_mp3'
for x in arg[2:]:
	if '/' in x:
		new_folder = x
	

if os.path.exists(var) == False:
	print 'Path Does Not Exist'
	sys.exit()

for x in arg[2:]:
	if x not in list and x.isdigit() == False and '/' not in x:
		info()
	if x in possible_formats:
		formats.append(x)
	if x.isdigit() == True:
		bitrate = str(x) + 'k'

if 'all' in arg and 'skip' in arg:
	info()


call(['mkdir', new_folder])
for x in os.listdir(var):
	file = var  + '/' + x
	x1 = x.split('.')
	if 'all' not in arg:
		if x1[-1] not in formats:
			if 'skip' in arg:
				continue
			print '\nError: No audio extension\nFile: ' + x
			var1 = raw_input('Continue (y/n) ')
			if var1 == 'n':
				continue
	del x1[-1]
	x2 = '.'.join(str(z) for z in x1)
	new_file = new_folder + '/' + x2 + '.mp3'
	call(['ffmpeg', '-i', file, '-c:a', 'libmp3lame', '-b:a', bitrate, new_file])  

