# i-MSCP - internet Multi Server Control Panel
# Copyright (C) 2013-2014 by Sascha Bay
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

#
## Listener file that allows to setup sender canonical map.
#

package Listener::Postfix::Sender::Canonical;
 
use strict;
use warnings;
use iMSCP::Debug;
use iMSCP::HooksManager;
use iMSCP::Execute;

#
## Configuration variables
#

my $postfixSenderCanoncial = '/etc/postfix/imscp/sender_canonical';
my $addSenderCanoncial = "sender_canonical_maps = hash:/etc/postfix/imscp/sender_canonical\n";
 
#
## Please, don't edit anything below this line
#

sub onAfterMtaBuildPostfixSenderCanoncial
{
	my $tplContent = shift;

	if (-f $postfixSenderCanoncial) {
		my ($stdout, $stderr);
		my $rs = execute("postmap $postfixSenderCanoncial", \$stdout, \$stderr);
		debug($stdout) if $stdout;
		error($stderr) if $stderr && $rs;
		return $rs if $rs;

		$$tplContent .= "$addSenderCanoncial";
	}

	0;
}

iMSCP::HooksManager->getInstance()->register('afterMtaBuildMainCfFile', \&onAfterMtaBuildPostfixSenderCanoncial);

1;
__END__
