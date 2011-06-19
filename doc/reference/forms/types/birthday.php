<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">birthday Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="birthday-field-type">
      <span id="index-0"></span><h1>birthday Field Type<a class="headerlink" href="#birthday-field-type" title="Permalink to this headline">¶</a></h1>
      <p>A <a class="reference internal" href="date.html"><em>date</em></a> field that specializes in handling
	birthdate data.</p>
      <p>Can be rendered as a single text box or three select boxes (month, day, and year)</p>
      <p>This type is essentially the same as the <tt class="docutils literal"><span class="pre">date</span></tt> type, but with a more appropriate
	default for the <tt class="docutils literal"><span class="pre">years</span></tt> option.   The <tt class="docutils literal"><span class="pre">years</span></tt> option defaults to 120
	years ago to the current year.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="15%">
	  <col width="85%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Underlying Data Type</td>
	    <td>can be <tt class="docutils literal"><span class="pre">DateTime</span></tt>, <tt class="docutils literal"><span class="pre">string</span></tt>, <tt class="docutils literal"><span class="pre">timestamp</span></tt>, or <tt class="docutils literal"><span class="pre">array</span></tt> (see the <a class="reference internal" href="date.html#form-reference-date-input"><em>input option</em></a>)</td>
	  </tr>
	  <tr><td>Rendered as</td>
	    <td>can be three select boxes or a text box, based on the <tt class="docutils literal"><span class="pre">widget</span></tt> option</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">years</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Inherited
	      options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">widget</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">input</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">months</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">days</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">format</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">pattern</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">data_timezone</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">user_timezone</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><a class="reference internal" href="date.html"><em>date</em></a></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/BirthdayType.html" title="Symfony\Component\Form\Extension\Core\Type\BirthdayType"><span class="pre">BirthdayType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">years</span></tt> [type: <tt class="docutils literal"><span class="pre">array</span></tt>, default: 120 years ago to the current year ]</dt>
	      <dd><p class="first last">List of years available to the year field type.  This option is only
		  relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
      <div class="section" id="inherited-options">
	<h2>Inherited options<a class="headerlink" href="#inherited-options" title="Permalink to this headline">¶</a></h2>
	<p>These options inherit from the <a class="reference internal" href="date.html"><em>date</em></a> type:</p>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">widget</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">choice</span></tt>]</dt>
	      <dd><p class="first">Type of widget used for this form type.  Can be <tt class="docutils literal"><span class="pre">text</span></tt> or <tt class="docutils literal"><span class="pre">single_text</span></tt> or <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
		<blockquote class="last">
		  <div><ul class="simple">
		      <li><tt class="docutils literal"><span class="pre">text</span></tt>: renders a three field input of type text (month, day, year).</li>
		      <li><tt class="docutils literal"><span class="pre">single_text</span></tt>: renders a single input of type text. User's input is validated
			based on the <tt class="docutils literal"><span class="pre">format</span></tt> option.</li>
		      <li><tt class="docutils literal"><span class="pre">choice</span></tt>: renders three select inputs.  The order of the selects
			is defined in the <tt class="docutils literal"><span class="pre">pattern</span></tt> option.</li>
		    </ul>
		</div></blockquote>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">input</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">datetime</span></tt>]</dt>
	      <dd><p class="first">The value of the input for the widget.  Can be <tt class="docutils literal"><span class="pre">string</span></tt>, <tt class="docutils literal"><span class="pre">datetime</span></tt>
		  or <tt class="docutils literal"><span class="pre">array</span></tt>.  The form type input value will be returned  in the format
		  specified.  The input of <tt class="docutils literal"><span class="pre">April</span> <span class="pre">21th,</span> <span class="pre">2011</span></tt> as an array would return:</p>
		<div class="last highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span><span class="s1">'month'</span> <span class="o">=&gt;</span> <span class="mi">4</span><span class="p">,</span> <span class="s1">'day'</span> <span class="o">=&gt;</span> <span class="mi">21</span><span class="p">,</span> <span class="s1">'year'</span> <span class="o">=&gt;</span> <span class="mi">2011</span> <span class="p">)</span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">months</span></tt> [type: array, default: 1 to 12 ]</dt>
	      <dd><p class="first last">List of months available to the month field type. This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">days</span></tt> [type: array, default: 1 to 31 ]</dt>
	      <dd><p class="first">List of days available to the day field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
		<div class="last highlight-php"><div class="highlight"><pre><span class="s1">'days'</span> <span class="o">=&gt;</span> <span class="nb">range</span><span class="p">(</span><span class="mi">1</span><span class="p">,</span><span class="mi">31</span><span class="p">)</span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">format</span></tt> [type: integer, default: IntlDateFormatter::MEDIUM]</dt>
	      <dd><p class="first last">Option passed to the IntlDateFormatter class, used to transform user input
		  into the proper format. This is critical when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is
		  set to <tt class="docutils literal"><span class="pre">text</span></tt>, and will define how to transform the input.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">pattern</span></tt> [type: string, default: null]</dt>
	      <dd><p class="first">This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.
		  The default pattern is based off the <tt class="docutils literal"><span class="pre">format</span></tt> option, and tries to
		  match the characters <tt class="docutils literal"><span class="pre">M</span></tt>, <tt class="docutils literal"><span class="pre">d</span></tt>, and <tt class="docutils literal"><span class="pre">y</span></tt> in the format pattern. If
		  no match is found, the default is the string <tt class="docutils literal"><span class="pre">{{</span> <span class="pre">year</span> <span class="pre">}}-{{</span> <span class="pre">month</span> <span class="pre">}}-{{</span> <span class="pre">day</span> <span class="pre">}}</span></tt>.
		  Tokens for this option include:</p>
		<blockquote class="last">
		  <div><ul class="simple">
		      <li><tt class="docutils literal"><span class="pre">{{</span> <span class="pre">year</span> <span class="pre">}}</span></tt>: Replaced with the <tt class="docutils literal"><span class="pre">year</span></tt> widget</li>
		      <li><tt class="docutils literal"><span class="pre">{{</span> <span class="pre">month</span> <span class="pre">}}</span></tt>: Replaced with the <tt class="docutils literal"><span class="pre">month</span></tt> widget</li>
		      <li><tt class="docutils literal"><span class="pre">{{</span> <span class="pre">day</span> <span class="pre">}}</span></tt>: Replaced with the <tt class="docutils literal"><span class="pre">day</span></tt> widget</li>
		    </ul>
		</div></blockquote>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">data_timezone</span></tt> [type: string, default: system default timezone]</dt>
	      <dd><p class="first last">Timezone for the data being stored.  This must be one of the <a class="reference external" href="http://php.net/manual/en/timezones.php">PHP supported timezones</a></p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">user_timezone</span></tt> [type: string, default: system default timezone]</dt>
	      <dd><p class="first last">Timezone for the data being submitted by the user.  This must be one of the <a class="reference external" href="http://php.net/manual/en/timezones.php">PHP supported timezones</a></p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Form Types Reference" href="../types.html">
      «&nbsp;Form Types Reference
    </a><span class="separator">|</span>
    <a accesskey="N" title="checkbox Field Type" href="checkbox.html">
      checkbox Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
