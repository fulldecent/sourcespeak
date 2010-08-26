<span class="lnr">  1</span>  <span class="Comment">/*</span><span class="Comment">***********************************************************************************</span>
<span class="lnr">  2</span>  <span class="Comment"> *                                                            PROGRAM IMPLEMENTATION</span>
<span class="lnr">  3</span>  <span class="Comment"> * Tyler McHenry</span>
<span class="lnr">  4</span>  <span class="Comment"> * Independant Project &amp; AP Computer Science AB</span>
<span class="lnr">  5</span>  <span class="Comment"> * </span>
<span class="lnr">  6</span>  <span class="Comment"> * ChatterBox (A Peer-to-Peer Chat Program)</span>
<span class="lnr">  7</span>  <span class="Comment"> * </span>
<span class="lnr">  8</span>  <span class="Comment"> * File: &quot;chatterbox.cpp&quot;</span>
<span class="lnr">  9</span>  <span class="Comment"> * </span>
<span class="lnr"> 10</span>  <span class="Comment"> * History: I initially tried to write this in C++ using MS Visual C++ and MFC. </span>
<span class="lnr"> 11</span>  <span class="Comment"> *          That failed. Horribly. I've now rewritten it in C for the UNIX </span>
<span class="lnr"> 12</span>  <span class="Comment"> *          console's more logical sockets. This program uses the curses library </span>
<span class="lnr"> 13</span>  <span class="Comment"> *          for screen manipulation. (Note: It has now gone back into C++)</span>
<span class="lnr"> 14</span>  <span class="Comment"> *</span>
<span class="lnr"> 15</span>  <span class="Comment"> * Comments: THIS IS CURRENT BETA CODE UNDER DEVELOPMENT. IT HAS NOT BE COMPLETED</span>
<span class="lnr"> 16</span>  <span class="Comment"> *           OR DEBUGGED. USE AT YOUR OWN RISK. Please excuse the old C-sytle</span>
<span class="lnr"> 17</span>  <span class="Comment"> *           comments everywhere; as stated above, this was initially just in C.</span>
<span class="lnr"> 18</span>  <span class="Comment"> * </span>
<span class="lnr"> 19</span>  <span class="Comment"> * Description: This program, when started, listens for incoming connections on</span>
<span class="lnr"> 20</span>  <span class="Comment"> *              the #define'ed port. However, you can also initiate your own</span>
<span class="lnr"> 21</span>  <span class="Comment"> *              connections to others using the /connect command. Once you have</span>
<span class="lnr"> 22</span>  <span class="Comment"> *              connected to another client, the listening socket is temporarily</span>
<span class="lnr"> 23</span>  <span class="Comment"> *              shut off (as this is only a 2-person chat). When you are</span>
<span class="lnr"> 24</span>  <span class="Comment"> *              connected, you may freely send text and emotes back and forth</span>
<span class="lnr"> 25</span>  <span class="Comment"> *              as in any normal chat program. </span>
<span class="lnr"> 26</span>  <span class="Comment"> *              (</span><span class="Todo">TODO</span><span class="Comment">: Rewrite the above!!)</span>
<span class="lnr"> 27</span>  <span class="Comment"> * </span>
<span class="lnr"> 28</span>  <span class="Comment"> *              All of the crazy peer-to-peer heap negotiation and optimization</span>
<span class="lnr"> 29</span>  <span class="Comment"> *              is handled in the background, and will not be visible to the end</span>
<span class="lnr"> 30</span>  <span class="Comment"> *              user unless debugging is specifically enabled. Visible failure</span>
<span class="lnr"> 31</span>  <span class="Comment"> *              will only occur when a severe network disruption (a large number</span>
<span class="lnr"> 32</span>  <span class="Comment"> *              of nodes die at once) occurs. This is a self-correcting system.              </span>
<span class="lnr"> 33</span>  <span class="Comment"> * </span>
<span class="lnr"> 34</span>  <span class="Comment"> * Input: All input is user-entered on the command line. No files are read.</span>
<span class="lnr"> 35</span>  <span class="Comment"> * </span>
<span class="lnr"> 36</span>  <span class="Comment"> * Output: All output is to the screen through curses. No files are written to.</span>
<span class="lnr"> 37</span>  <span class="Comment"> * </span>
<span class="lnr"> 38</span>  <span class="Comment"> * Version History: 1.0.0       (01-08-2001) Initial Version </span>
<span class="lnr"> 39</span>  <span class="Comment"> *                  1.9.0 ALPHA (15-05-2002) Began Development on 2.0, added GPL </span>
<span class="lnr"> 40</span>  <span class="Comment"> *                  1.9.1 ALPHA (23-05-2002) Finished split into classes </span>
<span class="lnr"> 41</span>  <span class="Comment"> *                  1.9.2 ALPHA (25-05-2002) Rewrote functions to fit new design </span>
<span class="lnr"> 42</span>  <span class="Comment"> *                  1.9.3 BETA  (27-05-2002) Message passing system works fine</span>
<span class="lnr"> 43</span>  <span class="Comment"> * </span>
<span class="lnr"> 44</span>  <span class="Comment"> * Licensing:</span>
<span class="lnr"> 45</span>  <span class="Comment"> * </span>
<span class="lnr"> 46</span>  <span class="Comment"> *      Copyright (C) 2001, 2002 Tyler McHenry (tyler@nerdland.net)</span>
<span class="lnr"> 47</span>  <span class="Comment"> * </span>
<span class="lnr"> 48</span>  <span class="Comment"> *      Chatterbox is free software; you can redistribute it and/or</span>
<span class="lnr"> 49</span>  <span class="Comment"> *      modify it under the terms of the GNU General Public License</span>
<span class="lnr"> 50</span>  <span class="Comment"> *      as published by the Free Software Foundation; either version 2</span>
<span class="lnr"> 51</span>  <span class="Comment"> *      of the License, or (at your option) any later version.</span>
<span class="lnr"> 52</span>  <span class="Comment"> *</span>
<span class="lnr"> 53</span>  <span class="Comment"> *      Chatterbox is distributed in the hope that it will be useful,</span>
<span class="lnr"> 54</span>  <span class="Comment"> *      but WITHOUT ANY WARRANTY; without even the implied warranty of</span>
<span class="lnr"> 55</span>  <span class="Comment"> *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the</span>
<span class="lnr"> 56</span>  <span class="Comment"> *      GNU General Public License for more details.</span>
<span class="lnr"> 57</span>  <span class="Comment"> *</span>
<span class="lnr"> 58</span>  <span class="Comment"> *      You should have received a copy of the GNU General Public License</span>
<span class="lnr"> 59</span>  <span class="Comment"> *      along with Chatterbox; see the file LICENSE. If not, write to the Free </span>
<span class="lnr"> 60</span>  <span class="Comment"> *      Software Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA </span>
<span class="lnr"> 61</span>  <span class="Comment"> *      02111-1307, USA. Or visit <A HREF="http://www.gnu.org/licenses/gpl.html">http://www.gnu.org/licenses/gpl.html</A></span>
<span class="lnr"> 62</span>  <span class="Comment"> *</span>
<span class="lnr"> 63</span>  <span class="Comment"> **********************************************************************************</span><span class="Comment">*/</span>
<span class="lnr"> 64</span>
<span class="lnr"> 65</span>  <span class="Comment">// INCLUDES =========================================================================</span>
<span class="lnr"> 66</span>
<span class="lnr"> 67</span>  <span class="PreProc">#include </span><span class="Constant">&quot;chatdefines.h&quot;</span><span class=""> </span><span class="Comment">// #define's specific to chatterbox, plus data structs    </span>
<span class="lnr"> 68</span>  <span class="PreProc">#include </span><span class="Constant">&quot;chatdisplay.h&quot;</span><span class=""> </span><span class="Comment">// Class to handle the ncurses display                    </span>
<span class="lnr"> 69</span>  <span class="PreProc">#include </span><span class="Constant">&quot;chatengine.h&quot;</span><span class="">  </span><span class="Comment">// Class to handle the backend communications             </span>
<span class="lnr"> 70</span>  <span class="PreProc">#include </span><span class="Constant">&lt;stdio.h&gt;</span><span class="">       </span><span class="Comment">// For error messages independant of curses               </span>
<span class="lnr"> 71</span>  <span class="PreProc">#include </span><span class="Constant">&lt;stdlib.h&gt;</span><span class="">      </span><span class="Comment">// Standard C Functions                                   </span>
<span class="lnr"> 72</span>  <span class="PreProc">#include </span><span class="Constant">&lt;unistd.h&gt;</span><span class="">      </span><span class="Comment">// More of the same                                       </span>
<span class="lnr"> 73</span>  <span class="PreProc">#include </span><span class="Constant">&lt;sys/types.h&gt;</span><span class="">   </span><span class="Comment">// -|                                                     </span>
<span class="lnr"> 74</span>  <span class="PreProc">#include </span><span class="Constant">&lt;sys/socket.h&gt;</span><span class="">  </span><span class="Comment">//  |                                                     </span>
<span class="lnr"> 75</span>  <span class="PreProc">#include </span><span class="Constant">&lt;netinet/in.h&gt;</span><span class="">  </span><span class="Comment">//  |= Socket Functions                                   </span>
<span class="lnr"> 76</span>  <span class="PreProc">#include </span><span class="Constant">&lt;netdb.h&gt;</span><span class="">       </span><span class="Comment">//  |                                                     </span>
<span class="lnr"> 77</span>  <span class="PreProc">#include </span><span class="Constant">&lt;arpa/inet.h&gt;</span><span class="">   </span><span class="Comment">// -|                                                     </span>
<span class="lnr"> 78</span>  <span class="PreProc">#include </span><span class="Constant">&lt;ncurses.h&gt;</span><span class="">     </span><span class="Comment">// Advanced screen manipulation                           </span>
<span class="lnr"> 79</span>  <span class="PreProc">#include </span><span class="Constant">&lt;string.h&gt;</span><span class="">      </span><span class="Comment">// For memset() when compiled as C++                      </span>
<span class="lnr"> 80</span>
<span class="lnr"> 81</span>  <span class="Comment">// OTHER FUNCTIONS ===================================================================</span>
<span class="lnr"> 82</span>
<span class="lnr"> 83</span>  <span class="Type">enum</span><span class=""> messagetype determine_type(</span><span class="Type">char</span><span class="">* buffer)</span>
<span class="lnr"> 84</span>
<span class="lnr"> 85</span>  <span class="">  </span><span class="Comment">// PRE : buffer is the raw buffer form the display object</span>
<span class="lnr"> 86</span>  <span class="">  </span><span class="Comment">// POST: Returns the type of data entered as a messagetype, may modify buffer</span>
<span class="lnr"> 87</span>  <span class="">  </span><span class="Comment">// DESC: Tests the first few characters of buffer against recognized commands. If</span>
<span class="lnr"> 88</span>  <span class="">  </span><span class="Comment">//       it is a command, the command portion is stripped from buffer, leaving</span>
<span class="lnr"> 89</span>  <span class="">  </span><span class="Comment">//       only the parameters to the command. If no command is found, mtText is </span>
<span class="lnr"> 90</span>  <span class="">  </span><span class="Comment">//       returned.</span>
<span class="lnr"> 91</span>  <span class="">  </span>
<span class="lnr"> 92</span>  <span class="">  </span>
<span class="lnr"> 93</span>  <span class="">{</span>
<span class="lnr"> 94</span>  <span class="">   </span><span class="Type">enum</span><span class=""> messagetype retval = mtText;</span>
<span class="lnr"> 95</span>  <span class="">   </span><span class="Type">int</span><span class=""> i;</span>
<span class="lnr"> 96</span>  <span class="">   </span>
<span class="lnr"> 97</span>  <span class="">   </span><span class="Comment">// IDEA: Is there a regexp parser for C++ that I could use here?</span>
<span class="lnr"> 98</span>  <span class="">   </span>
<span class="lnr"> 99</span>  <span class="">   </span><span class="Statement">if</span><span class=""> (buffer[</span><span class="Constant">0</span><span class="">] == </span><span class="Constant">'/'</span><span class="">) {                            </span><span class="Comment">// All commands begin with / </span>
<span class="lnr">100</span>  <span class="">      </span><span class="Statement">if</span><span class=""> (strncmp(buffer, </span><span class="Constant">&quot;/quit&quot;</span><span class="">, </span><span class="Constant">5</span><span class="">) == </span><span class="Constant">0</span><span class="">) {         </span><span class="Comment">// Identify command          </span>
<span class="lnr">101</span>  <span class="">         </span><span class="Statement">if</span><span class=""> (strncmp(buffer, </span><span class="Constant">&quot;/quit</span><span class="Special">\0</span><span class="Constant">&quot;</span><span class="">, </span><span class="Constant">6</span><span class="">) != </span><span class="Constant">0</span><span class="">) {    </span><span class="Comment">// If it has parameters,     </span>
<span class="lnr">102</span>  <span class="">            </span><span class="Statement">for</span><span class=""> (i = </span><span class="Constant">6</span><span class="">; i &lt; (ENTRY_LEN - </span><span class="Constant">35</span><span class="">); i++) {  </span><span class="Comment">// strip the command part,   </span>
<span class="lnr">103</span>  <span class="">               buffer[(i - </span><span class="Constant">6</span><span class="">)] = buffer[i];           </span><span class="Comment">// leaving only the          </span>
<span class="lnr">104</span>  <span class="">            }                                         </span><span class="Comment">// parameters.               </span>
<span class="lnr">105</span>  <span class="">         } </span><span class="Statement">else</span><span class=""> {                                     </span><span class="Comment">// If there are no parameters</span>
<span class="lnr">106</span>  <span class="">            buffer[</span><span class="Constant">0</span><span class="">] = </span><span class="Special">'\0'</span><span class="">;                         </span><span class="Comment">// simply nullify buffer.          </span>
<span class="lnr">107</span>  <span class="">         }</span>
<span class="lnr">108</span>  <span class="">         retval = mtQuit;</span>
<span class="lnr">109</span>  <span class="">      } </span><span class="Statement">else</span><span class=""> </span><span class="Statement">if</span><span class=""> (strncmp(buffer, </span><span class="Constant">&quot;/me&quot;</span><span class="">, </span><span class="Constant">3</span><span class="">) == </span><span class="Constant">0</span><span class="">) {  </span><span class="Comment">// Every block works like this </span>
<span class="lnr">110</span>  <span class="">         retval = mtEmote;</span>
<span class="lnr">111</span>  <span class="">         </span><span class="Statement">if</span><span class=""> (strncmp(buffer, </span><span class="Constant">&quot;/me</span><span class="Special">\0</span><span class="Constant">&quot;</span><span class="">, </span><span class="Constant">4</span><span class="">) != </span><span class="Constant">0</span><span class="">) {</span>
<span class="lnr">112</span>  <span class="">            </span><span class="Statement">for</span><span class=""> (i = </span><span class="Constant">4</span><span class="">; i &lt; ENTRY_LEN; i++) {</span>
<span class="lnr">113</span>  <span class="">               buffer[(i - </span><span class="Constant">4</span><span class="">)] = buffer[i];</span>
<span class="lnr">114</span>  <span class="">            }</span>
<span class="lnr">115</span>  <span class="">         } </span><span class="Statement">else</span><span class=""> {</span>
<span class="lnr">116</span>  <span class="">            buffer[</span><span class="Constant">0</span><span class="">] = </span><span class="Special">'\0'</span><span class="">;</span>
<span class="lnr">117</span>  <span class="">         }</span>
<span class="lnr">118</span>  <span class="">      } </span><span class="Statement">else</span><span class=""> </span><span class="Statement">if</span><span class=""> (strncmp(buffer, </span><span class="Constant">&quot;/nick &quot;</span><span class="">, </span><span class="Constant">6</span><span class="">) == </span><span class="Constant">0</span><span class="">) {</span>
<span class="lnr">119</span>  <span class="">         </span><span class="Statement">if</span><span class=""> ((buffer[</span><span class="Constant">5</span><span class="">] != </span><span class="Special">'\0'</span><span class="">) &amp;&amp; (buffer[</span><span class="Constant">6</span><span class="">] != </span><span class="Special">'\0'</span><span class="">)) {</span>
<span class="lnr">120</span>  <span class="">            </span><span class="Statement">for</span><span class=""> (i = </span><span class="Constant">6</span><span class="">; i &lt; </span><span class="Constant">20</span><span class=""> &amp;&amp; buffer[i] != </span><span class="Special">'\0'</span><span class=""> ; i++) {</span>
<span class="lnr">121</span>  <span class="">               buffer[(i - </span><span class="Constant">6</span><span class="">)] = buffer[i];</span>
<span class="lnr">122</span>  <span class="">            }</span>
<span class="lnr">123</span>  <span class="">            buffer[i-</span><span class="Constant">6</span><span class="">] = </span><span class="Special">'\0'</span><span class="">;</span>
<span class="lnr">124</span>  <span class="">         }</span>
<span class="lnr">125</span>  <span class="">         buffer[</span><span class="Constant">14</span><span class="">] = </span><span class="Special">'\0'</span><span class="">;</span>
<span class="lnr">126</span>  <span class="">         retval = mtNick;</span>
<span class="lnr">127</span>  <span class="">      } </span><span class="Statement">else</span><span class=""> </span><span class="Statement">if</span><span class=""> (strncmp(buffer, </span><span class="Constant">&quot;/disconnect&quot;</span><span class="">, </span><span class="Constant">11</span><span class="">) == </span><span class="Constant">0</span><span class="">) {</span>
<span class="lnr">128</span>  <span class="">         </span><span class="Statement">if</span><span class=""> (strncmp(buffer, </span><span class="Constant">&quot;/disconnect</span><span class="Special">\0</span><span class="Constant">&quot;</span><span class="">, </span><span class="Constant">12</span><span class="">) != </span><span class="Constant">0</span><span class="">) {</span>
<span class="lnr">129</span>  <span class="">            </span><span class="Statement">for</span><span class=""> (i = </span><span class="Constant">12</span><span class="">; i &lt; (ENTRY_LEN - </span><span class="Constant">23</span><span class="">); i++) {</span>
<span class="lnr">130</span>  <span class="">               buffer[(i - </span><span class="Constant">12</span><span class="">)] = buffer[i];</span>
<span class="lnr">131</span>  <span class="">            }</span>
<span class="lnr">132</span>  <span class="">         } </span><span class="Statement">else</span><span class=""> {</span>
<span class="lnr">133</span>  <span class="">            buffer[</span><span class="Constant">0</span><span class="">] = </span><span class="Special">'\0'</span><span class="">;</span>
<span class="lnr">134</span>  <span class="">         }</span>
<span class="lnr">135</span>  <span class="">      } </span><span class="Statement">else</span><span class=""> </span><span class="Statement">if</span><span class=""> (strncmp(buffer, </span><span class="Constant">&quot;/connect&quot;</span><span class="">, </span><span class="Constant">8</span><span class="">) == </span><span class="Constant">0</span><span class="">) {</span>
<span class="lnr">136</span>  <span class="">         </span><span class="Statement">for</span><span class=""> (i = </span><span class="Constant">9</span><span class="">; i &lt; ENTRY_LEN; i++) {</span>
<span class="lnr">137</span>  <span class="">            buffer[(i - </span><span class="Constant">9</span><span class="">)] = buffer[i];</span>
<span class="lnr">138</span>  <span class="">         }</span>
<span class="lnr">139</span>  <span class="">         retval = mtHello;</span>
<span class="lnr">140</span>  <span class="">      }</span>
<span class="lnr">141</span>  <span class="">   }</span>
<span class="lnr">142</span>  <span class="">   </span>
<span class="lnr">143</span>  <span class="">   </span><span class="Statement">return</span><span class=""> retval;</span>
<span class="lnr">144</span>  <span class="">}</span>
<span class="lnr">145</span>
<span class="lnr">146</span>  <span class="Comment">// MAIN PROGRAM =====================================================================</span>
<span class="lnr">147</span>
<span class="lnr">148</span>  <span class="Type">int</span><span class=""> main()</span>
<span class="lnr">149</span>  <span class="">{</span>
<span class="lnr">150</span>  <span class="">   fd_set read_fds;              </span><span class="Comment">// Temp copy of master for polling descriptors    </span>
<span class="lnr">151</span>  <span class="">   fd_set list_fds;              </span><span class="Comment">// Temp copy of listeners for polling</span>
<span class="lnr">152</span>  <span class="">   </span><span class="Type">int</span><span class=""> i, j;                     </span><span class="Comment">// Iterators                                      </span>
<span class="lnr">153</span>  <span class="">   </span><span class="Type">char</span><span class=""> keybuf[ENTRY_LEN];       </span><span class="Comment">// Keep data as the user is typing    </span>
<span class="lnr">154</span>  <span class="">   </span><span class="Type">char</span><span class=""> * pkeybuf = </span><span class="Constant">NULL</span><span class="">;</span>
<span class="lnr">155</span>  <span class="">   </span><span class="Type">enum</span><span class=""> messagetype entrytype;   </span><span class="Comment">// The type of command that the user has entered  </span>
<span class="lnr">156</span>  <span class="">   </span><span class="Type">int</span><span class=""> curchar;                  </span><span class="Comment">// Newest character code read from the keyboard   </span>
<span class="lnr">157</span>  <span class="">   </span><span class="Type">bool</span><span class=""> quit = </span><span class="Constant">false</span><span class="">;</span>
<span class="lnr">158</span>  <span class="">   </span>
<span class="lnr">159</span>  <span class="">   ChatDisplay cbDisplay;          </span><span class="Comment">// ncurses display engine object</span>
<span class="lnr">160</span>  <span class="">   ChatEngine cbEngine(cbDisplay); </span><span class="Comment">// backend communications object</span>
<span class="lnr">161</span>  <span class="">   </span>
<span class="lnr">162</span>  <span class="">   </span><span class="Statement">while</span><span class="">(!quit) { </span>
<span class="lnr">163</span>  <span class="">                 </span>
<span class="lnr">164</span>  <span class="">      read_fds = cbEngine.get_active_fds(); </span><span class="Comment">// Keep things up to date </span>
<span class="lnr">165</span>  <span class="">      list_fds = cbEngine.get_listeners();</span>
<span class="lnr">166</span>
<span class="lnr">167</span>  <span class="">      FD_SET(STDI, &amp;read_fds); </span><span class="Comment">// Add the keyboard</span>
<span class="lnr">168</span>  <span class="">      </span>
<span class="lnr">169</span>  <span class="">      </span><span class="Comment">// Wait for input   </span>
<span class="lnr">170</span>  <span class="">      select((cbEngine.get_max_fd() + </span><span class="Constant">1</span><span class="">), &amp;read_fds, </span><span class="Constant">NULL</span><span class="">, </span><span class="Constant">NULL</span><span class="">, </span><span class="Constant">NULL</span><span class="">);    </span>
<span class="lnr">171</span>  <span class="">      </span>
<span class="lnr">172</span>  <span class="">      </span><span class="Comment">// Seek and find which descriptor(s) have data to be read, and handle </span>
<span class="lnr">173</span>  <span class="">      </span>
<span class="lnr">174</span>  <span class="">      </span><span class="Statement">for</span><span class=""> (i = </span><span class="Constant">0</span><span class="">; i &lt;= cbEngine.get_max_fd() &amp;&amp; !quit; i++) { </span>
<span class="lnr">175</span>  <span class="">         </span><span class="Statement">if</span><span class=""> (FD_ISSET(i, &amp;read_fds)) {</span>
<span class="lnr">176</span>  <span class="">              </span>
<span class="lnr">177</span>  <span class="">              </span><span class="Statement">if</span><span class=""> (i == STDI) {  </span><span class="Comment">// The user typed something </span>
<span class="lnr">178</span>  <span class="">                 </span>
<span class="lnr">179</span>  <span class="">                 curchar = getch(); </span><span class="Comment">// Get the character code typed </span>
<span class="lnr">180</span>  <span class="">                 </span>
<span class="lnr">181</span>  <span class="">                 </span><span class="Statement">if</span><span class=""> (cbDisplay.add_keystroke(curchar)) {</span>
<span class="lnr">182</span>  <span class="">                    pkeybuf = cbDisplay.get_input();</span>
<span class="lnr">183</span>  <span class="">                    strcpy(keybuf, pkeybuf);</span>
<span class="lnr">184</span>  <span class="">                    free(pkeybuf);</span>
<span class="lnr">185</span>  <span class="">                    cbDisplay.clear_input();</span>
<span class="lnr">186</span>  <span class="">                    entrytype = determine_type(keybuf);</span>
<span class="lnr">187</span>
<span class="lnr">188</span>  <span class="">                    </span><span class="Statement">switch</span><span class=""> (entrytype) { </span><span class="Comment">// Take action based on type of entry </span>
<span class="lnr">189</span>  <span class="">                     </span><span class="Statement">case</span><span class=""> mtNick:</span>
<span class="lnr">190</span>  <span class="">                       cbEngine.change_nick(keybuf);</span>
<span class="lnr">191</span>  <span class="">                       </span><span class="Statement">break</span><span class="">;</span>
<span class="lnr">192</span>  <span class="">                     </span><span class="Statement">case</span><span class=""> mtHello:  </span><span class="Comment">// AKA &quot;Connect&quot; </span>
<span class="lnr">193</span>  <span class="">                       cbEngine.connect(keybuf);</span>
<span class="lnr">194</span>  <span class="">                       </span><span class="Statement">break</span><span class="">;</span>
<span class="lnr">195</span>  <span class="">                     </span><span class="Statement">case</span><span class=""> mtQuit:</span>
<span class="lnr">196</span>  <span class="">                       quit = </span><span class="Constant">true</span><span class="">; </span><span class="Comment">// Fallthrough intentional              </span>
<span class="lnr">197</span>  <span class="">                     </span><span class="Statement">case</span><span class=""> mtDiscon:</span>
<span class="lnr">198</span>  <span class="">                       cbEngine.disconnect(keybuf);</span>
<span class="lnr">199</span>  <span class="">                       </span><span class="Statement">break</span><span class="">;</span>
<span class="lnr">200</span>  <span class="cUserCont">                     </span><span class="Statement">default</span><span class="cUserCont">:</span>
<span class="lnr">201</span>  <span class="">                       cbEngine.send_packet(keybuf, entrytype);</span>
<span class="lnr">202</span>  <span class="">                       </span><span class="Statement">break</span><span class="">;</span>
<span class="lnr">203</span>  <span class="">                    }</span>
<span class="lnr">204</span>  <span class="">                    </span>
<span class="lnr">205</span>  <span class="">                 }</span>
<span class="lnr">206</span>  <span class="">                 </span>
<span class="lnr">207</span>  <span class="">              } </span><span class="Statement">else</span><span class=""> </span><span class="Statement">if</span><span class=""> (FD_ISSET(i, &amp;list_fds)) { </span>
<span class="lnr">208</span>  <span class="">                 </span><span class="Comment">// There's a new connection afoot </span>
<span class="lnr">209</span>  <span class="">                 cbEngine.connect(i);</span>
<span class="lnr">210</span>  <span class="">              </span>
<span class="lnr">211</span>  <span class="">              } </span><span class="Statement">else</span><span class=""> { </span><span class="Comment">// Recieved some data </span>
<span class="lnr">212</span>  <span class="">                 cbEngine.recv_packet(i);</span>
<span class="lnr">213</span>  <span class="">              }</span>
<span class="lnr">214</span>  <span class="">         }</span>
<span class="lnr">215</span>  <span class="">      }      </span>
<span class="lnr">216</span>  <span class="">   }</span>
<span class="lnr">217</span>  <span class="">   </span>
<span class="lnr">218</span>  <span class="">   </span><span class="Statement">return</span><span class=""> </span><span class="Constant">0</span><span class="">;     </span><span class="Comment">// ... and we're out of here. </span>
<span class="lnr">219</span>  <span class="">}</span>

