#11-16-17; mint
import os, readline, os.path
from subprocess import call
list = []
output = 'choose'
down_format = 'best[ext=mp4]'
count = 0
output_folder = '/home/jonathan/Documents/youtube_downloads'

os.system('ls /home/jonathan > /home/jonathan/f.txt')
f = open('/home/jonathan/f.txt', 'r').read().split('\n')

def move():
	global output_folder
	os.system('ls /home/jonathan > /home/jonathan/a.txt')
	a = open('/home/jonathan/a.txt', 'r').read().split('\n')
	for x in a:
		if x not in f:
			file = '/home/jonathan/' + x
			call(['mv',file, output_folder])
def info(a):
	call(['youtube-dl', '-F', a])

def file(a):
	var = raw_input('Enter the format code ')
	command = 'youtube-dl -o "' + output_folder + '/%(title)s.%(ext)s" -f ' + str(var) + ' ' + str(a)
	list.append(command)

def mp4(a):
	command = 'youtube-dl -o "' + output_folder + '/%(title)s.%(ext)s" -f best[ext=mp4] ' + str(a)
	list.append(command)

def mp3(a):
	command = 'youtube-dl -o "' + output_folder + '/%(title)s.%(ext)s" -f bestaudio ' + str(a)
	list.append(command)

def settings():
	var = 0
	global output, down_format, output_folder
	while var != '':
		os.system('clear')
		print 'Settings\n'
		print 'Output folder: ' + str(output_folder)
		print_f()
		var = raw_input('\n(a) to change output type; (b) to change output folder ')
		if var == 'a':
			var2 = raw_input('(a) for mp4; (b) for audio only; (c) choose type ')
			if var2 == 'a':
				output = 'mp4'
				down_format = 'best[ext=mp4]'
			if var2 == 'b':
				output = 'audio'
				down_format = 'bestaudio'
			if var2 == 'c':
				output = 'choose'
		if var == 'b':
			while True:
				os.system('clear')
				print 'Settings\n'
				print 'Output folder: ' + str(output_folder)
				var3 = raw_input('\nEnter the output folder; (d) for default; (n) to create new folder ')
				if var3 == '':
					break
				if var3 == 'n':
					var4 = raw_input('Enter desired folder name, and path if location other than home directory is desired ')
					call(['mkdir', var4])
					if os.path.isdir(var4) == True:
						output_folder = var4
					break	
				if var3 == 'd':
					output_folder = '/home/jonathan/Documents/youtube_downloads'
					break
				if os.path.exists(var3) == False:
					print 'Path does not exist'
					continue
				output_folder = var3
				break

def choice(a):
	if output == 'choose':
		info(a)
		file(a)
	if output == 'mp4':
		mp4(a)
	if output == 'audio':
		mp3(a)

def print_f():
	if output == 'choose':
		print 'Output Format: User Choice'
	if output == 'mp4':
		print 'Output Format: MP4 Video'
	if output == 'audio':
		print 'Output Format: Audio Only'

def delete():
	if os.path.isfile(output_folder + '/a.txt') == True:
		os.system('rm ' + output_folder + '/a.txt')

def enter():
	var = 0
	while var != '':
		var = raw_input('\nDone! Press "Enter" ')

def message():
	print 'Playlists and Channels are downloaded as mp4 videos by default.\nGo to settings to change downloads to audio only.\n'

def clear():
	os.system('clear')

def start():
	print 'Welcome to Youtube Downloader!\n'
	print '\nAt any point, press "Enter" to return to home screen.'
	variable = raw_input('\n\nPress "Enter" to continue!')
	clear()

while True:
	clear()
	count += 1
	delete()
	list = []
	if count == 1:
		start()
	print 'Output folder: ' + str(output_folder)
	print_f()
	var = raw_input('\n(a) single video; (b) batch convert; (c) text file; (d) playlist; (e) channel; (s) settings ')
	if var == 'a':
		url = raw_input('Enter the video url. ')
		if url == '':
			continue
		choice(url)
	if var == 'b':
		while True:
			url = raw_input('Enter the video url; (d) when done. ')
			if url == '':
				break
			if url == 'd':
				break
			choice(url)
		if url == '':
			continue
	if var == 'c':
		txt_file = raw_input('Enter the text file. ')
		if os.path.isfile(txt_file) == False:
			continue
		video_list = open(txt_file, 'r').readlines()
		var1 = raw_input('(a) mp4; (b) audio; (c) choose for each ')
		if var1 == 'a':
			for x in video_list:
				mp4(x)
		if var1 == 'b':
			for x in video_list:
				mp3(x)
		if var1 == 'c':
			for x in video_list:
				info(x)
				file(x)
	if var == 'd':
		clear()
		message()
		url = raw_input('Enter the playlist url. ')
		if url == '':
			continue
		call(['youtube-dl', '-citw', '-f', down_format, url])
		#os.system('youtube-dl -o "%(playlist)s/%(playlist_index)s - %(title)s.%(ext)s" -i -f ' + down_format + ' ' + url)
		move()
		enter()
		continue
	if var == 'e':
		clear()
		message()
		print 'Many times, the channel name will not work.\nThe channel user name must be entered.',
		print '\nFor instance, instead of "UFC - Ultimate Fighting Championship" channel name, "UFC" must be entered.\nThe user is often found in the url.\n\n'
		name = raw_input('Enter channel. ')
		if name == '':
			continue
		channel = 'ytuser:' + name
		call(['youtube-dl', '-citw', '-f', down_format, channel])
		move()
		enter()
		continue
	if var == 's':
		settings()
		continue
	for x in list:
		os.system(x)
	#move()
	if var in ['a', 'b', 'c']:
		enter()
	

















