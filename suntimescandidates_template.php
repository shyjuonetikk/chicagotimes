<?php /** Template name: Candidate */ ?>

<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>suntimescandidates</title>
  <meta name="description" content="suntimescandidates">
  <meta name="author" content="suntimescandidates">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/suntimescandidates_style.css">

  <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
  <div class="container">

    <div id="main-logo">
      <div class="main-logo-box">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/main-logo.png">
      </div>
    </div>

    <nav class="navbar navbar-inverse navbar-static-top suntimes-nav">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar6">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand text-hide" href="#">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/ChicagoSunTimes.jpg">
        </a>
      </div>
      <div id="navbar6" class="navbar-collapse collapse">
        <?php wp_nav_menu( array( 'theme_location' => 'candidates-menu', 'items_wrap' => '<ul class="nav navbar-nav pull-right">%3$s</ul>' ) ); ?>
          <li class="active"><a href="#">2016 General Election</a>
          </li>
          <li><a href="#">2015 Chicago Election</a>
          </li>
          <li><a href="#">Print</a>
          </li>
          <li><a href="#">2017 4th Ward</a>
          </li>

        </ul>
      </div>
      <!--/.nav-collapse -->
    </nav>

    <div class="main-content">
      <div class="main-top-content">
        <h2 class="main-title">Chicago Sun-Times Editorial Board<br>2016 primary election questionnaires</h2>
        <p class="main-parag">Linked below are responses from congressional, legislative and county candidates
          to Chicago Sun-Times Editorial Board questionnaires. The Board made endorsements
          in contested races based on these questionnaires as well as interviews with
          candidates and research by the Board. Read our endorsements for <a href="">U.S. Senate</a>;
          Congress: <a href="">Districts 1-6</a>, <a href="">District 8</a>, <a href="">Districts 7-14</a>;
          the <a href="">Illinois Senate</a>, including the <a href="">2nd District</a>;
          the <a href="">Illinois House</a>, including the <a href="">26th District</a>;
          <a href="">Cook  County state's attorney</a>; <a href="">MWRD</a>; <a href="">Cook County Circuit Court clerk</a>.
          and U.S. President (<a href="">Dem</a>, <a href="">GOP</a>). A ✔ indicates an
          endorsed candidate. </p>
          <?php $screen = get_current_screen(); ?> 
      </div>

      <div class="suntimes-lbox col-sm-12">
        <h2 class="lbox-title">U.S. President</h2>
        <hr>
        <div class="lbox-lbox-6">
          <h3 class="blue">Democrat</h3>
          <ul>
            <li>Hillary Clinton <span class="blue"> ✔ </span>
            </li>
            <li>Bernie Sanders</li>
            <li>Willie L. Wilson</li>
            <li>Roque "Rocky" de la Fuente</li>
            <li>Martin J. O'Malley</li>
            <li>Larry "Lawrence" Cohen</li>
          </ul>
        </div>

        <div class="lbox-lbox-6">
          <h3 class="red">Republican</h3>
          <ul class="lbox-ul-2">
            <li>Jeb Bush</li>
            <li>Ben Carson</li>
            <li>Chris Christie</li>
            <li>Ted Cruz</li>
            <li>Carly Fiorina</li>
            <li>Jim Gilmore</li>
          </ul>
          <ul class="lbox-ul-2">
            <li>Marco Rubio</li>
            <li>John Kasich <span class="red"> ✔ </span>
            </li>
            <li>Donald Trump</li>
            <li>Rand Paul</li>
            <li>Mike Huckabee</li>
            <li>Rick Santorum</li>
          </ul>
        </div>

      </div><!-- suntimes-lbox -->

      <div class="suntimes-lbox col-sm-12">
        <h2 class="lbox-title">U.S. Senate</h2>
        <hr>
        <div class="lbox-lbox-6">
          <h3 class="blue">Democrat</h3>
          <ul>
            <li>Tammy Duckworth</li>
            <li>Andrea Zopp <span class="blue"> ✔ </span></li>
            <li>Napoleon Harris</li>
          </ul>
        </div>

        <div class="lbox-lbox-6">
          <h3 class="red">Republican</h3>
          <ul>
            <li>Mark Kirk</li>
            <li>James Marter</li>
            <li></li>
          </ul>
        </div>

      </div><!-- suntimes-lbox -->

      <div class="suntimes-lbox US-House col-sm-12">
        <h2 class="lbox-title">U.S. House</h2>
        <hr>
        <div class="row">
        <div class="lbox-lbox-4">
          <h3>1st District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Bobby L. Rush <span class="blue"> ✔ </span></li>
            <li>Howard B. Brookins Jr. </li>
            <li>O. Patrick Brutus</li>
          </ul>
          <h4 class="red">Republican</h4>
          <ul>
            <li>Jimmy Lee Tillman II </li>
            <li>August "O'Neill" Deuser</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
        <h3>2nd District </h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Robin Kelly<span class="blue"> ✔ </span></li>
            <li>Marcus Lewis</li>
            <li>Charles Rayburn</li>
            <li>Dorian C.L. Myrickes</li>
          </ul>
          <h4 class="red">Republican</h4>
          <ul>
            <li>John F. Morrow</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
          <h3>3rd District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Dan Lipinski</li>
          </ul>
        </div>
        </div><!-- row -->


        <div class="row">
        <div class="lbox-lbox-4">
          <h3>4th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Luis V. Gutiérrez <span class="blue"> ✔ </span></li>
            <li>Javier Salas</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
        <h3>5th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Mike Quigley</li>
          </ul>
          <h4 class="green">Green</h4>
          <ul>
            <li>Warren "Grizz" Grimsley<span class="green"> ✔ </span></li>
            <li> Rob Sherman</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
          <h3>6th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Robert Marshall</li>
            <li>Amanda Howland <span class="blue"> ✔ </span></li>
          </ul>
          <h4 class="red">Republican</h4>
          <ul>
            <li>Peter J. Roskam</li>
            <li>Gordon "Jay" Kinzler</li>
          </ul>
        </div>
        </div><!-- row -->
      </div><!-- suntimes-lbox -->


      <div class="suntimes-lbox col-sm-12">
        <h2 class="lbox-title">Illinois Comptroller</h2>
        <hr>
        <div class="lbox-lbox-6">
          <h3 class="blue">Democrat</h3>
          <ul>
            <li>Susana Mendoza</li>
          </ul>
        </div>

        <div class="lbox-lbox-6">
          <h3 class="red">Republican</h3>
          <ul>
            <li>Leslie Geissler Munger</li>
          </ul>
        </div>

      </div><!-- suntimes-lbox -->


      <div class="suntimes-lbox Illinois-state-senate col-sm-12">
        <h2 class="lbox-title">Illinois State Senate</h2>
        <hr>
        <div class="row">
        <div class="lbox-lbox-4">
          <h3>1st District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Antonio "Tony" Munoz</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
        <h3>2nd District </h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Angelica Alfaro</li>
            <li>Omar Aquino</li>
            </ul>
        </div>

        <div class="lbox-lbox-4">
          <h3>4th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Kimberly A. Lightford</li>
          </ul>
        </div>
        </div><!-- row -->


        <div class="row">
        <div class="lbox-lbox-4">
          <h3>5th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Patricia Van Pelt</li>
            <li>Robert "Bob" Fioretti</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
        <h3>7th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Heather A. Steans</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
          <h3>8th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Ira I. Silverstein</li>
          </ul>
        </div>
        </div><!-- row -->
      </div><!-- suntimes-lbox -->


        <div class="suntimes-lbox Illinois-state-senate col-sm-12">
        <h2 class="lbox-title">Illinois House of Representatives</h2>
        <hr>
        <div class="row">
        <div class="lbox-lbox-4">
          <h3>1st District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Daniel J. Burke</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
        <h3>2nd District </h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Alexander "Alex" Acevedo</li>
            <li>Theresa Mah<span class="blue"> ✔ </span></li>
            </ul>
        </div>

        <div class="lbox-lbox-4">
          <h3>3rd District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Luis Arroyo</li>
          </ul>
        </div>
        </div><!-- row -->


        <div class="row">
        <div class="lbox-lbox-4">
          <h3>4th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Cynthia Soto<span class="blue"> ✔ </span></li>
            <li>Robert "Bob Z" Zwolinski</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
        <h3>5th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Kenneth "Ken" Dunkin</li>
            <li>Juliana Stratton<span class="blue"> ✔ </span></li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
          <h3>6th District</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Sonya Marie Harper </li>
            <li>Genita C. Robinson<span class="blue"> ✔ </span></li>
            <li>Darryl D. Smith </li>
            <li>Kenyatta Nicole Vaughn</li>
          </ul>
        </div>
        </div><!-- row -->
      </div><!-- suntimes-lbox -->


      <div class="suntimes-lbox Cook-County col-sm-12">
        <h2 class="lbox-title">Cook County</h2>
        <hr>
        <div class="row">
        <div class="lbox-lbox-4 spc-height">
          <h3>State's Attorney</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Donna More</li>
            <li>Kim Foxx<span class="blue"> ✔ </span></li>
            <li>Anita Alvarez</li>
          </ul>
          <h4 class="red">Republican</h4>
          <ul>
            <li>Christopher E.K. Pfannkuche</li>
          </ul>
        </div>

        <div class="lbox-lbox-4 spc-height">
        <h3>Circuit Court Clerk</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Dorothy Brown</li>
            <li>Michelle Harris</li>
            <li>Jacob Meister<span class="blue"> ✔ </span></li>
            </ul>
            <h4 class="red">Republican</h4>
          <ul>
            <li>Diane Shapiro</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
          <h3>Recorder of Deeds</h3>
          <h4 class="blue">Democrat</h4>
          <ul>
            <li>Karen Yarbrough</li>
          </ul>
          <hr>
          <h3>Board of Review</h3>
          <h4>1st District (<span class="red">Republican</span>)</h4>
          <ul>
            <li>Dan Patlak</li>
          </ul>
          <h4>2nd District (<span class="blue">Democrat</span>)</h4>
          <ul>
            <li>Michael Cabonargi</li>
          </ul>
        </div>
        </div><!-- row -->
      </div><!-- suntimes-lbox -->


      <div class="suntimes-lbox col-sm-12">
        <h2 class="lbox-title">Metropolitan Water Reclamation District</h2>
        <hr>
        <div class="lbox-lbox-8">
          <h5><b>(Three 6-year terms)</b></h5>
          <ul class="lbox-ul-2">
          <h3 class="blue">Democrat</h3>
            <li>Mariyana Spyropoulos</li>
            <li>Barbara McGowan</li>
            <li>Josina Morita</li>
            <li>Joseph Daniel Cook</li>
            <li>Kevin McDevitt</li>
            <li>R. Cary Capparelli</li>
          </ul>
          <ul class="lbox-ul-2">
          <h3 class="green">Green</h3>
            <li>Karen Roothaan</li>
            <li>George Milkowski</li>
            <li>Michael Smith</li>
          </ul>
        </div>

        <div class="lbox-lbox-4">
        <h5><b>(One 2-year term)</b></h5>
        <h3 class="blue">Democrat</h3>
          <ul>
            <li>Tom Greenhaw</li>
            <li>Andrew Seo</li>
            <li>Martin J. Durkan</li>
          </ul>
          <h3 class="red">Republican</h3>
          <ul>
            <li>Herb Schumann</li>
          </ul>
        </div>

      </div><!-- suntimes-lbox -->


      <div class="suntimes-lbox col-sm-12">
        <h2 class="lbox-title">BINDING REFERENDUMS</h2>
        <hr>
        <p>The <a href="#">Illinois Transportation Taxes and Fees Lockbox Amendment</a>, which would bar lawmakers from using transportation funds for anything other than their stated purpose.<span class="red"><b>NO</b></span></p>
        <p>Shall the <a href="#">Office of the Cook County Recorder of Deeds be eliminated</a> and all duties and responsibilities of the Office of the Cook County Recorder of Deeds be transferred to, and assumed by, the Office of the Cook County Clerk by December 7, 2020? <span class="red"><b>YES</b></span></p>

      </div><!-- suntimes-lbox -->





    </div>
    <!-- main-content -->

    <div class="sidebar">

    </div>
    <div class="sidebar">

    </div>
    <p class="copyright">Copyright © 2017 All rights reserved.</p>

  </div>
  <!-- wrapper -->

</body>

</html>