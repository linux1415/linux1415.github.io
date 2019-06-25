#11-10-17; mint
import os, readline, os.path
from subprocess import call
resolution = ''
bitrate = ''
same_quality = '-q:v 0'

def mkv():
	convert_folder = '/home/jonathan/Documents/converter_files/'
	def convert(a):
		if os.path.exists(a) == False:
			print 'Path does not exist'
			return
		filename = os.listdir(a)
		for x in filename:
			if x.endswith('mkv') == True:
				file = str(a) + '/' + str(x)
				name = convert_folder + (os.path.basename(file)[:-4]) + '.mp4'
				call(['ffmpeg', '-i', file, '-c:a', 'copy', '-c:v', 'copy', name])
			#os.system(('ffmpeg -i /Users/jonathanfisher/Desktop/test/"' +str(x)+ '" -c:a copy -c:v copy "'+ str(x[:-4]) +'".mp4'))
	var = raw_input('Enter the path of the folder containing the files to convert. ')
	convert(var)

def calculator():
	var = raw_input('How many megabytes are desired? ')
	var1 = raw_input('How many minutes is the movie? ')
	if not var.isdigit() or not var1.isdigit():
		return
	var2 = ((int(var) * 8192) / (int(var1)*60)) - 192
	print var2

def portion_cutter(s, m, d, new_movie):
	call(['ffmpeg', '-ss', str(s), '-i', str(m), '-c', 'copy', '-t', str(d), new_movie])
	
#def portion_cutter(s, m, d, new_movie):
	#call(['ffmpeg', '-ss', str(s), '-i', str(m), '-q:v', '0', '-to', str(d), '-c:v', 'msmpeg4v2', new_movie])
	
def container_converter(movie, container):
	os.system(('ffmpeg -i "' + str(movie) + '" -c:a copy -c:v copy "' + str(movie[:-4]) + '"_new.' + str(container)))

def h264(movie, resolution, bitrate):
	os.system(('ffmpeg -y -i "' + str(movie) + '" -c:v libx264 -preset veryfast'+ str(resolution) +' ' + str(bitrate) + ' -pass 1 -c:a libmp3lame -b:a 192k -f mp4 /dev/null && \
ffmpeg -i "' + str(movie) + '" -c:v libx264 -preset veryfast'+ str(resolution) + ' '+ str(bitrate) +' -pass 2 -c:a libmp3lame -b:a 192k "' + str(movie[:-4]) + '"_new.mp4'))

def avi(movie, resolution, bitrate, same_quality):
	os.system(('ffmpeg -i "' + str(movie) + '" '+ str(same_quality) +''+ str(resolution) +' ' + str(bitrate) + ' -c:v mpeg4 "' +  str(movie[:-4]) + '"_new.avi'))


while True:	
	list = []
	container = ''
	var = raw_input('(a) for container converter; (b) for h.264 converter; (c) for .avi converter; (d) info; (e) grab a portion; (m) mkv to mp4 ')
	if var == 'm':
		mkv()
		continue
	if var == 'e':
		portion = raw_input('Enter movie; start seconds; duration. ')
		while container not in ['mp4', 'avi']:
			container = raw_input('Enter the format (avi, mp4) ')
		portion = portion.split()
		if len(portion) == 3:
			m = portion[0] ; s = portion[1] ; d = portion[2]
			new_movie = str(m[:-4]) + '_new.' + str(container)
			portion_cutter(s, m, d, new_movie)
		continue
	if var == 'd':
		movie_file = raw_input('Enter the movie file. ')
		os.system(('ffmpeg -i "' + str(movie_file) + '"'))
		continue
	if var[0:2] == 'ls' or var[0:3] == 'pwd':
		os.system(str(var))
		continue
	if var == 'clear':
		os.system('clear')
		continue

	while True:	
		movie = raw_input('\nEnter the movie; or (b) for batch convert ')
		if movie == 'b':
			batch_convert = raw_input('"Enter" for single files; (f) for folder ')
			if batch_convert == 'f':
				batch_folder = raw_input('Enter the folder ')
				if os.path.exists(batch_folder) == False:
					print 'Path does not exist'
					continue
				for x in os.listdir(batch_folder):
					list.append(batch_folder + '/' + x)
				break
			while True:
				movie = raw_input('Enter the movie; (d) when done ')
				if movie == 'd':
					break
				if os.path.exists(movie) == False:
					print 'Path does not exist'
					continue	
				list.append(movie)
			break
		if os.path.exists(movie) != False:
			list.append(movie)
			break
		else:
			print 'Path does not exist'
		
	if var != 'a':
		while True:
			resolution = raw_input('What resolution? (a) 1080x720 (b) 720x480 (c) 640x480 (d) 352x480 (e) default. ')
			if resolution == 'a':
				resolution = ' -s 1080x720'
				break
			if resolution == 'b':
				resolution = ' -s 720x480' 
				break
			if resolution == 'c':
				resolution = ' -s 640x480'
				break
			if resolution == 'd':
				resolution = ' -s 352x480'
				break
			if resolution == 'e':
				resolution = ''
				break
		while not bitrate.isdigit():
			bitrate = raw_input('Enter the desired bitrate. Or (c) for calculator ')
			if bitrate == 'c':
				calculator()
		bitrate = (('-b:v ' + str(bitrate) + 'k'))
	
	if var == 'a':
		while container not in ['mp4', 'avi']:
			container = raw_input('Enter the format (avi, mp4) ')
		for movie in list:
			container_converter(movie, container)
	if var == 'b':
		for movie in list:
			h264(movie, resolution, bitrate)
	if var == 'c':
		quality = raw_input('Use same quality feature (y/n). ')
		if quality == 'n':
			same_quality = ''	
		for movie in list:
			avi(movie, resolution, bitrate, same_quality)


