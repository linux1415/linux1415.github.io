#python subnetting.py; this will print out CIDR subnet masks
#python subnetting.py <network address> <subnet mask>; this will print out subnetting summary
#python subnetting.py <network address> <subnet mask> -list; this will print out each individual subnet and its info

import sys, os

list = sys.argv

info = ['255.0.0.0', '255.128.0.0', '255.192.0.0', '255.224.0.0', '255.240.0.0', '255.248.0.0', '255.252.0.0', '255.254.0.0', '255.255.0.0', '255.255.128.0', '255.255.192.0', '255.255.224.0', '255.255.240.0', '255.255.248.0', '255.255.252.0', '255.255.254.0', '255.255.255.0', '255.255.255.128', '255.255.255.192', '255.255.255.224', '255.255.255.240', '255.255.255.248', '255.255.255.252']



def subnet_info():
	count = 8; ip_space = 15
	for x in info:
		num = ''
		var = x.split('.')
		for y in var:
			if y != '255' and y != '0':
				num = "{0:b}".format(int(y))
		if num == '':
			num = '00000000'
		spaces = ip_space - len(x)
		print num + ' | ' + x + spaces*' ' + ' | /' + str(count)
		count += 1

if len(list) < 2:
	subnet_info()
	sys.exit()

network_address = list[1]
subnet_mask = list[2]

if subnet_mask not in info or '.' not in network_address:
	print 'Error: Subnet Mask or Network Address Not Valid'
	sys.exit()


def get_class(a):
	var = a.split('.')
	if var[1] == '0' and var[2] == '0' and var[3] == '0':
		ip_class = 'a'
	elif var[2] == '0' and var[3] == '0':
		ip_class = 'b'
	elif var[3] == '0':
		ip_class = 'c'
	else:
		print 'Error'
		sys.exit()
	return ip_class

def host_portion_of_mask(a, b): #subnet_mask, network_address
	var = a.split('.')
	if get_class(b) == 'a':
		host_portion = var[1]
	if get_class(b) == 'b':
		host_portion = var[2]
	if get_class(b) == 'c':
		host_portion = var[3]
	return host_portion

def count_ones(a):
	count = 0
	for x in a:
		if x == '1':
			count += 1
	return count

def count_zeros(a, b):
	count = 0
	for x in a:
		if x == '0':
			count += 1
	if b == 'a':
		count += 24
	if b == 'b':
		count += 8
	return count

def subnet_nums(a,b):
	global increment
	sub_list = [0]
	increment = 256 - int(host_portion_of_mask(a, b))
	count = 0
	for x in range(255):
		count += 1
		if count % increment == 0:
			sub_list.append(count)
	return sub_list

def broadcast_host(a, b): #network_address, ip_class
	var = a.split('.')
	broad_list = []
	host_range = []
	count = 0
	for x in subnet_numbers:
		if x == subnet_numbers[-1]:
			host = '255'
		else:
			host = str((int(subnet_numbers[(count+1)]) - 1))
		if b == 'a':
			ip = var[0] + '.' + str((int(x)+int(increment))-1) + '.255.255'
			host_range.append([var[0] + '.' + str(x) + '.0.' + str(x+1), var[0] + '.' + str(x) + '.0.' + str(int(host) - 1)])
		elif b == 'b':
			ip = var[0] + '.' + var[1] + '.' + str((int(x)+int(increment))-1) + '.255'
			host_range.append([var[0] + '.' + var[1] + '.' + str(x) + '.1', var[0] + '.' + var[1] + '.' + str((int(x)+int(increment))-1) + '.254'])
		elif b == 'c':
			ip = var[0] + '.' + var[1] + '.' + var[2] + '.' + host
			host_range.append([var[0] + '.' + var[1] + '.' + var[2] + '.' +  str(x+1), var[0] + '.' + var[1] + '.' + var[2] + '.'  + str(int(host) - 1)])
		count += 1
		broad_list.append(ip)
	return broad_list, host_range

def subnet_addresses(a):
	temp_list = []
	var = a.split('.')
	for x in subnet_numbers:
		if var[1] == '0':
			new = var[0] + '.' + str(x) + '.0.0'
		elif var[2] == '0':
			new = var[0] + '.' + var[1] + '.' + str(x) + '.0'
		else:
			new = var[0] + '.' + var[1] + '.' + var[2] + '.' + str(x)
		temp_list.append(new)
	return temp_list

def subnet_addresses2(a, b):
	var = a.split('.')
	if var[1] == '0':
		new = var[0] + '.' + str(b) + '.0.0'
		return new
	elif var[2] == '0':
		new = var[0] + '.' + var[1] + '.' + str(b) + '.0'
		return new
	else:
		new = var[0] + '.' + var[1] + '.' + var[2] + '.' + str(b)
		return new
	
		
ip_class = get_class(network_address)
host_bits = "{0:b}".format(int(host_portion_of_mask(subnet_mask, network_address)))
subnets_available = pow(2, int(count_ones(host_bits)))
hosts_per_subnet = pow(2, int(count_zeros(host_bits, ip_class))) - 2
subnet_numbers = subnet_nums(subnet_mask, network_address) #list
subnet_broadcast_and_host_addresses = broadcast_host(network_address, ip_class) #list
broadcast, host = subnet_broadcast_and_host_addresses #list

if '-list' in list:
	print 'Network Address: ' + network_address
	print 'Subnet Mask: ' + subnet_mask
	print 'Available Subnets: ' + str(subnets_available)
	print 'Number of hosts per subnet: ' + str(hosts_per_subnet) + '\n'
	count = 0
	for x in subnet_numbers:
		var_list = network_address.split('.')
		print 'Subnet: ' + subnet_addresses2(network_address,x)
		print 'Broadcast Address: ',
		print broadcast[count]
		print 'Available Hosts: ',
		print str(host[count][0]) + ' - ' + str(host[count][1])
		print '\n'
		count += 1
	sys.exit()
		

print 'Network Address: ' + network_address + '\nSubnet Mask: ' + subnet_mask
print 'Available Subnets: ' + str(subnets_available)
print 'Number of hosts per subnet: ' + str(hosts_per_subnet) + '\n'
print 'Subnet Numbers:'
print subnet_addresses(network_address)
print '\nBroadcast Addresses of Subnets:'
print broadcast
print '\nHost Ranges for Subnets:'
print host





































