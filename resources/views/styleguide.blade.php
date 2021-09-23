@extends('layouts.app')


@section('content')
<link rel="stylesheet" href="{{ asset('css/docs.min.css') }}">
<style type="text/css">
  .h1-big-sm {
    font: Bold 42px/44px DM Sans !important;
    letter-spacing: 0.75px !important;
  }

  .h1-smaller-sm {
    font: Bold 30px/36px DM Sans !important;
    letter-spacing: 0.54px !important;
  }

  .h2-sm {
    font: Bold 24px/30px DM Sans !important;
    letter-spacing: 0.43px !important;
  }

  .h3-sm {
    font: Bold 18px/21px DM Sans !important;
    letter-spacing: 0.32px !important;
  }

  .h4-intro-sm {
    font: Bold 16px/27px DM Sans !important;
    letter-spacing: 0 !important;
  }

  .paragraph-sm {
    font: Regular 14px/24px DM Sans !important;
    letter-spacing: 0 !important;
  }

  .paragraph-small-sm {
    font: Regular 14px/24px DM Sans !important;
    letter-spacing: 0 !important;
  }
</style>
<div class="container">
    <h2>Main Colors</h2>
    <div class="bd-example" data-example-id="">
      <button class="btn bk-success" style="width: 151px; height: 151px;">#78E6D0<div class="ripple-container"></div></button>
      <button class="btn bk-primary" style="width: 151px; height: 151px; color:white">#06038D<div class="ripple-container"></div></button>
      <button class="btn bk-warn" style="width: 151px; height: 151px;">#FF6B6B<div class="ripple-container"></div></button>
      <button class="btn bk-basic" style="width: 151px; height: 151px; color:white">#020A09<div class="ripple-container"></div></button>
      <button class="btn bk-grey-1" style="width: 151px; height: 151px;">#8C9196<div class="ripple-container"></div></button>
      <button class="btn bk-grey-2" style="width: 151px; height: 151px;">#DAEIE5<div class="ripple-container"></div></button>
      <button class="btn bk-grey-3" style="width: 151px; height: 151px;">#EBF0F4<div class="ripple-container"></div></button>
      <button class="btn bk-grey-4" style="width: 151px; height: 151px;">#F8FAFD<div class="ripple-container"></div></button>
    </div>    
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html" style="font-size: 14px">
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn bk-success"</span><span class="nt">&gt;</span>#78E6D0<span class="nt">&lt;/button&gt;</span>
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn bk-primary"</span><span class="nt">&gt;</span>#06038D<span class="nt">&lt;/button&gt;</span>
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn bk-warn"</span><span class="nt">&gt;</span>#FF6B6B<span class="nt">&lt;/button&gt;</span>
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn bk-basic"</span><span class="nt">&gt;</span>#020A09<span class="nt">&lt;/button&gt;</span>                
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn bk-grey-1"</span><span class="nt">&gt;</span>#8C9196<span class="nt">&lt;/button&gt;</span>
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn bk-grey-2"</span><span class="nt">&gt;</span>#DAEIE5<span class="nt">&lt;/button&gt;</span>
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn bk-grey-3"</span><span class="nt">&gt;</span>#EBF0F4<span class="nt">&lt;/button&gt;</span>
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn bk-grey-4"</span><span class="nt">&gt;</span>#F8FAFD<span class="nt">&lt;/button&gt;</span>
            </code>
        </pre>
    </div>
    <h2>Typography (DESKTOP) </h2>
    <div class="bd-example">
        <p class="h1-big">H1 Big</p>
        <p class="h1-smaller">H1 Smaller</p>
        <p class="h2">H2</p>
        <p class="h3">H3 Big</p>
        <p class="h4-intro">H4 intro</p>
        <p class="paragraph">Paragraph</p>
        <p class="paragraph-small">Paragraph Small</p>
        <p class="button-font">Button</p>
    </div>    
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html" style="font-size: 14px">
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h1-big"</span><span class="nt">&gt;</span>H1 Big<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h1-smaller"</span><span class="nt">&gt;</span>H1 Smaller<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h2"</span><span class="nt">&gt;</span>H2<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h3"</span><span class="nt">&gt;</span>H3 Big<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h4-intro"</span><span class="nt">&gt;</span>H4 intro<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"paragraph"</span><span class="nt">&gt;</span>Paragraph<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"paragraph-small"</span><span class="nt">&gt;</span>Paragraph Small<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"button-font"</span><span class="nt">&gt;</span>Button<span class="nt">&lt;/p&gt;</span>

            </code>
        </pre>
    </div>
    <h2>Typography (MOBILE) </h2>
    <div class="bd-example">
        <p class="h1-big-sm">H1 Big</p>
        <p class="h1-smaller-sm">H1 Smaller</p>
        <p class="h2-sm">H2</p>
        <p class="h3-sm">H3 Big</p>
        <p class="h4-intro-sm">H4 intro</p>
        <p class="paragraph-sm">Paragraph</p>
        <p class="paragraph-small-sm">Paragraph Small</p>
        <p class="button-font-sm">Button</p>
    </div>    
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html" style="font-size: 14px">
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h1-big-sm"</span><span class="nt">&gt;</span>H1 Big<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h1-smaller-sm"</span><span class="nt">&gt;</span>H1 Smaller<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h2-sm"</span><span class="nt">&gt;</span>H2<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h3-sm"</span><span class="nt">&gt;</span>H3 Big<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"h4-intro-sm"</span><span class="nt">&gt;</span>H4 intro<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"paragraph-sm"</span><span class="nt">&gt;</span>Paragraph<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"paragraph-small-sm"</span><span class="nt">&gt;</span>Paragraph Small<span class="nt">&lt;/p&gt;</span>
                <span class="nt">&lt;p</span> <span class="na">class=</span><span class="s">"button-font-sm"</span><span class="nt">&gt;</span>Button<span class="nt">&lt;/p&gt;</span>

            </code>
        </pre>
    </div>
    <h2>Buttons</h2>
    <div class="bd-example" data-example-id="">
        <div>
            <button class="btn btn-primary">Primary<div class="ripple-container"></div></button>
        </div>
        <div>
            <button class="btn btn-secondary" style="margin-top: 20px;">Secondary<div class="ripple-container"></div></button>
        </div>
    </div>    
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html" style="font-size: 14px">
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn btn-primary"</span><span class="nt">&gt;</span>#78E6D0<span class="nt">&lt;/button&gt;</span>
                <span class="nt">&lt;button</span> <span class="na">class=</span><span class="s">"btn btn-secondary"</span><span class="nt">&gt;</span>#06038D<span class="nt">&lt;/button&gt;</span>                
            </code>
        </pre>
    </div>
    <h2>Checkbox</h2>
    <div class="bd-example" data-example-id="">
      <div class="form-check">
        <label class="form-check-label">
          <input class="form-check-input" type="checkbox" value="">
          Normal
          <span class="form-check-sign">
            <span class="custom-check check"></span>
          </span>
        </label>
      </div>
      <div class="form-check disabled">
        <label class="form-check-label">
          <input class="form-check-input" type="checkbox" value="" disabled="">
          Inactive
          <span class="form-check-sign">
            <span class="check"></span>
          </span>
        </label>
      </div>
    </div>
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html">
                <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"form-check"</span><span class="nt">&gt;</span>
                    <span class="nt">&lt;label</span> <span class="na">class=</span><span class="s">"form-check-label"</span><span class="nt">&gt;</span>                
                        <span class="nt">&lt;input</span> <span class="na">class=</span><span class="s">"form-check-input"</span> <span class="na">type=</span><span class="s">"checkbox"</span> <span class="na">value=</span><span class="s">""</span><span class="nt">&gt;</span>
                        Normal
                        <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"form-check-sign"</span><span class="nt">&gt;</span>
                            <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"custom-check check"</span><span class="nt">&gt;&lt;/span&gt;</span>
                        <span class="nt">&lt;/span&gt;</span>
                    <span class="nt">&lt;/label&gt;</span>
                <span class="nt">&lt;/div&gt;</span>

                <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"form-check"</span><span class="nt">&gt;</span>
                    <span class="nt">&lt;label</span> <span class="na">class=</span><span class="s">"form-check-label"</span><span class="nt">&gt;</span>                
                        <span class="nt">&lt;input</span> <span class="na">class=</span><span class="s">"form-check-input"</span> <span class="na">type=</span><span class="s">"checkbox"</span> <span class="na">value=</span><span class="s">""</span><span class="nt">&gt;</span>
                        Inactive
                        <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"form-check-sign"</span><span class="nt">&gt;</span>
                            <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"check"</span><span class="nt">&gt;&lt;/span&gt;</span>
                        <span class="nt">&lt;/span&gt;</span>
                    <span class="nt">&lt;/label&gt;</span>
                <span class="nt">&lt;/div&gt;</span>
            </code>
        </pre>
    </div>
    <h2>RadioButton</h2>
    <div class="bd-example" data-example-id="">
      <div class="form-check">
        <label class="form-check-label">
          <input class="form-check-input" type="radio" value="">
          Normal
          <span class="circle">
            <span class="custom-check check"></span>
          </span>
        </label>
      </div>
      <div class="form-check disabled">
        <label class="form-check-label">
          <input class="form-check-input" type="radio" value="" disabled="">
          Inactive
          <span class="circle">
            <span class="check"></span>
          </span>
        </label>
      </div>
    </div>
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html">
                <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"form-check"</span><span class="nt">&gt;</span>
                    <span class="nt">&lt;label</span> <span class="na">class=</span><span class="s">"form-check-label"</span><span class="nt">&gt;</span>                
                        <span class="nt">&lt;input</span> <span class="na">class=</span><span class="s">"form-check-input"</span> <span class="na">type=</span><span class="s">"radio"</span> <span class="na">value=</span><span class="s">""</span><span class="nt">&gt;</span>
                        Normal
                        <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"circle"</span><span class="nt">&gt;</span>
                            <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"custom-check check"</span><span class="nt">&gt;&lt;/span&gt;</span>
                        <span class="nt">&lt;/span&gt;</span>
                    <span class="nt">&lt;/label&gt;</span>
                <span class="nt">&lt;/div&gt;</span>

                <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"form-check"</span><span class="nt">&gt;</span>
                    <span class="nt">&lt;label</span> <span class="na">class=</span><span class="s">"form-check-label"</span><span class="nt">&gt;</span>                
                        <span class="nt">&lt;input</span> <span class="na">class=</span><span class="s">"form-check-input"</span> <span class="na">type=</span><span class="s">"radio"</span> <span class="na">value=</span><span class="s">""</span><span class="nt">&gt;</span>
                        Inactive
                        <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"circle"</span><span class="nt">&gt;</span>
                            <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"check"</span><span class="nt">&gt;&lt;/span&gt;</span>
                        <span class="nt">&lt;/span&gt;</span>
                    <span class="nt">&lt;/label&gt;</span>
                <span class="nt">&lt;/div&gt;</span>
            </code>
        </pre>
    </div>
    <h2>Input</h2>
    <div class="bd-example">
        <div class="form-group col-md-6 bmd-form-group">        
            <input type="text" class="form-control round-inputbox" id="company_name" placeholder="Normal">
        </div>
        <div class="form-group col-md-6 bmd-form-group">        
            <input type="text" class="form-control round-inputbox error" id="company_name" placeholder="Error">
        </div>
        <div class="form-group col-md-6 bmd-form-group">        
            <input type="text" class="form-control round-inputbox success" id="company_name" placeholder="Success">
        </div>
    </div>    
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html">                                
                <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"col"</span><span class="nt">&gt;</span>
                  <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="na">class=</span><span class="s">"form-control round-inputbox"</span> <span class="na">placeholder=</span><span class="s">"Normal"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;/div&gt;</span>                

                <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"col"</span><span class="nt">&gt;</span>
                  <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="na">class=</span><span class="s">"form-control round-inputbox error"</span> <span class="na">placeholder=</span><span class="s">"Error"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;/div&gt;</span>

                <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"col"</span><span class="nt">&gt;</span>
                  <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="na">class=</span><span class="s">"form-control round-inputbox success"</span> <span class="na">placeholder=</span><span class="s">"Success"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;/div&gt;</span>
            </code>
        </pre>
    </div>
    <h2></h2>
    <div class="bd-example">
        <select id="inputState" class="form-control">
                  <option selected disabled hidden>Choose...</option>
                  <option>...</option>
                </select>
    </div>    
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html" style="font-size: 14px">                
            </code>
        </pre>
    </div>
    <h2></h2>
    <div class="bd-example">          
    </div>    
    <div class="highlight">
        <pre>
            <code class="language-html" data-lang="html" style="font-size: 14px">                
            </code>
        </pre>
    </div>
</div>
@endsection

