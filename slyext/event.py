import re

from docutils import nodes, statemachine
from docutils.parsers import rst

class Event(rst.Directive):
	has_content = True
	required_arguments = 1
	optional_arguments = 0
	final_argument_whitespace = False
	option_spec = {
		'type':    rst.directives.unchanged_required,
		'in':      rst.directives.unchanged_required,
		'subject': rst.directives.unchanged_required,
		'out':     rst.directives.unchanged,
		'params':  rst.directives.unchanged
	}

	def _parseInline(self, text):
		string = statemachine.StringList([text])
		para   = nodes.container()

		self.state.nested_parse(string, 0, para)

		return para

	def _buildParamList(self, ul, params):
		for paramline in params.split("\n"):
			match = re.match('^([^ ]+) +\((.*?)\)(?:\s*(.*?))$', paramline)
			item  = nodes.list_item()

			item.append(nodes.literal('', match.group(1)))
			item.append(nodes.Text(' ('+match.group(2)+')'))

			if len(match.groups()) == 3 and len(match.group(3)) > 0:
				item.append(self._parseInline('(' + match.group(3) + ')'))

			ul.append(item)

		return ul

	def run(self):
		event   = self.arguments[0]
		anchor  = event.lower().replace('_', '-')
		kind    = self.options.get('type')
		inType  = self.options.get('in')
		outType = self.options.get('out') or 'void'
		subject = self.options.get('subject')
		params  = self.options.get('params') or ''
		desc    = u'\n'.join(self.content)

		# create section

		# optionally insert zero-width breaks:
		# event.replace('_', u"_\u200B")

		sec = nodes.section()
		sec.append(nodes.title('', event))
		sec['names'].append(anchor)

		self.state.document.note_implicit_target(sec, sec)

		# the signature

		sig = '%s %s(%s)' % (outType, event, inType)

		if kind == 'until':
			sig += ' BREAKS'

		# additional params for this event

		paramlist = None

		if len(params) > 0:
			paramlist = self._buildParamList(nodes.bullet_list(), params)

		# create actual definition list

		dl = nodes.definition_list('',
			nodes.definition_list_item('',
				nodes.term('', '', nodes.strong('', 'Signatur:')),
				nodes.definition('', nodes.literal('', sig))
			),
			nodes.definition_list_item('',
				nodes.term('', '', nodes.strong('', 'Beschreibung:')),
				nodes.definition('', self._parseInline(desc))
			),
			nodes.definition_list_item('',
				nodes.term('', '', nodes.strong('', 'Subject:')),
				nodes.definition('', self._parseInline(subject))
			)
		)

		if paramlist:
			dl.append(nodes.definition_list_item('',
				nodes.term('', '', nodes.strong('', 'Weitere Parameter:')),
				nodes.definition('', paramlist)
			))

		sec.append(dl)

		return [sec]

def setup(app):
	app.add_directive('slyevent', Event)
