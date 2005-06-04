" Vim syntax support file
" Maintainer: Bram Moolenaar <Bram@vim.org>
" Last Change: 2003 May 31
"	       (modified by David Ne\v{c}as (Yeti) <yeti@physics.muni.cz>)

" Transform a file into HTML, using the current syntax highlighting.

let term="gui"
syn on

" Set some options to make it work faster.
" Expand tabs in original buffer to get 'tabstop' correctly used.
" Don't report changes for :substitute, there will be many of them.
set notitle noicon
setlocal et
set report=1000000

" Split window to create a buffer with the HTML file.
new cache/tmp.html
"set modifiable
%d
set paste
set magic


wincmd p

let s:expandedtab = ' '
while strlen(s:expandedtab) < &ts
  let s:expandedtab = s:expandedtab . ' '
endwhile

" Loop over all lines in the original text.
" Use html_start_line and html_end_line if they are set.
if exists("html_start_line")
  let s:lnum = html_start_line
  if s:lnum < 1 || s:lnum > line("$")
    let s:lnum = 1
  endif
else
  let s:lnum = 1
endif
if exists("html_end_line")
  let s:end = html_end_line
  if s:end < s:lnum || s:end > line("$")
    let s:end = line("$")
  endif
else
  let s:end = line("$")
endif

while s:lnum <= s:end

  " Get the current line
  let s:line = getline(s:lnum)
  let s:len = strlen(s:line)
  let s:new = ""

    let s:new = '<span class="lnr">' . strpart('        ', 0, strlen(line("$")) - strlen(s:lnum)) . s:lnum . '</span>  '

  " Loop over each character in the line
  let s:col = 1
  while s:col <= s:len
    let s:startcol = s:col " The start column for processing text
    let s:id = synID(s:lnum, s:col, 1)
    let s:col = s:col + 1
    " Speed loop (it's small - that's the trick)
    " Go along till we find a change in synID
    while s:col <= s:len && s:id == synID(s:lnum, s:col, 1) | let s:col = s:col + 1 | endwhile

    " Output the text with the same synID, with class set to {s:id_name}
    let s:id = synIDtrans(s:id)
    let s:id_name = synIDattr(s:id, "name", "gui")
    let s:new = s:new . '<span class="' . s:id_name . '">' . substitute(substitute(substitute(substitute(substitute(strpart(s:line, s:startcol - 1, s:col - s:startcol), '&', '\&amp;', 'g'), '<', '\&lt;', 'g'), '>', '\&gt;', 'g'), '"', '\&quot;', 'g'), "\x0c", '<hr class="PAGE-BREAK">', 'g') . '</span>'

    if s:col > s:len
      break
    endif
  endwhile

  " Expand tabs
  let s:pad=0
  let s:start = 0
  let s:idx = stridx(s:line, "\t")
  while s:idx >= 0
    let s:i = &ts - ((s:start + s:pad + s:idx) % &ts)
    let s:new = substitute(s:new, '\t', strpart(s:expandedtab, 0, s:i), '')
    let s:pad = s:pad + s:i - 1
    let s:start = s:start + s:idx + 1
    let s:idx = stridx(strpart(s:line, s:start), "\t")
  endwhile

  exe "normal \<C-W>pa" . strtrans(s:new) . "\n\e\<C-W>p"
  let s:lnum = s:lnum + 1
  +
endwhile
" Finish with the last line
  exe "normal \<C-W>pa\e"


" Now, when we finally know which, we define the colors and styles
  8


" Add hyperlinks
%s+\(http://\S\{-}\)\(\([.,;:]\=\(\s\|$\)\)\|[\\"'<>]\)+<A HREF="\1">\1</A>\2+ge

" Cleanup
%s:\s\+$::e

wq
q
