**This project is dead. Call me if you want to take the torch.**

[![Build Status](https://travis-ci.org/fulldecent/sourcespeak.png?branch=master)](https://travis-ci.org/fulldecent/sourcespeak)
[![Code Climate](https://codeclimate.com/github/fulldecent/sourcespeak/badges/gpa.svg)](https://codeclimate.com/github/fulldecent/sourcespeak)

Source Speak 2.0 
============

Copyright (C) 2001-2014 William Entriken<br>
https://github.com/fulldecent/sourcespeak<br>
sourcespeak@phor.net

Source Speak is a turn-key system for displaying source code on your web site.

<p align="center">
<img src="https://i.imgur.com/XKWdKC0.png" width=200>
<img src="https://i.imgur.com/QqEph4i.png" width=200>
<img src="https://i.imgur.com/nb1mbfz.png" width=200>
<p>

Features
--------

**Uses Vim syntax hilighting engine**

  Source Speak uses the Vim engine to highlight the code. Any format supported
  by Vim (virtually everything) will be handled.

**Easily Themable**

All source code highlighting is done by a single CSS style sheet. To change
the look, simply edit `common.css`.

**Attach arbitrary metadata**

  You can display arbitrary metadata with each project, like Author, Version, etc.
  Simply choose the metadata to display in the `config.json` file.


Installation
------------

 1. Source Speak requires: PHP and Vim with syntax highlighting support
 2. `git clone https://github.com/fulldecent` or `tar xfz sourcespeak-*.tar.gz`
 3. Set permissions with `chown -R apache:apache cache metadata` or `chmod 777 cache/ metadata/`
 4. Add your source code to the `projects/` folder or use a softlink

Thank you for choosing Source Speak for your source code displaying needs.
