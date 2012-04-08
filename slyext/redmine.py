# -*- coding: utf-8

from docutils import nodes, utils
from docutils.parsers.rst.roles import set_classes

# credit goes to Doug Hellmann for all this
# (http://www.doughellmann.com/articles/how-tos/sphinx-custom-roles/)
def redmine_ticket_role(name, rawtext, text, lineno, inliner, options={}, content=[]):
	try:
		ticket_num = int(text)
		if ticket_num <= 0:
			raise ValueError
	except ValueError:
		msg = inliner.reporter.error(
			'Redmine ticket number must be a number greater than or equal to 1; '
			'"%s" is invalid.' % text, line=lineno)
		prb = inliner.problematic(rawtext, rawtext, msg)
		return [prb], [msg]

	node = make_link_node(rawtext, str(ticket_num), options)

	return [node], []

def make_link_node(rawtext, id, options):
	ref = 'https://projects.webvariants.de/issues/'+id
	set_classes(options)
	node = nodes.reference(rawtext, '#'+utils.unescape(id), refuri=ref, **options)

	return node

def setup(app):
	app.add_role('redmine', redmine_ticket_role)
	return
