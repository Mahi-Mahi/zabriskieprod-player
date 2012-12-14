
require 'json'
require 'active_support/core_ext'
File.open('conf.json', 'w').puts(Hash.from_xml(File.read('conf.xml')).to_json)


