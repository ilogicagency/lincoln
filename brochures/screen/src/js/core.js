(function($) {
	$(document).ready(function() {
		new App();
	});

})(jQuery);

(function($, window) {
	function App() {
		this.section, this.slide, this.colour;
		this.slides = [
			['lincoln-touchbrochure_designandstyle_frontconsole.png',
				'lincoln-touchbrochure_designandstyle_10inchcluster.png',
				'lincoln-touchbrochure_designandstyle_leds.png',
				'lincoln-touchbrochure_designandstyle_premiumleather.png',
				'lincoln-touchbrochure_designandstyle_sidemirrors.png',
				'lincoln-touchbrochure_designandstyle_splitwing.png',
				'colours'
			],
			['lincoln-touchbrochure_performance.png'],
			['lincoln-touchbrochure_drivecontrol_drivecontrol.png',
				'lincoln-touchbrochure_drivecontrol_drivestyle.png'],
			['lincoln-touchbrochure_safetyandsecurity.png'],
			['lincoln-touchbrochure_comfortandconvenience.png']
		];
		this.colours = [
			'lincoln-touchbrochure_designandstyle_colour10.png',
			'lincoln-touchbrochure_designandstyle_colour01.png',
			'lincoln-touchbrochure_designandstyle_colour08.png',
			'lincoln-touchbrochure_designandstyle_colour09.png',
			'lincoln-touchbrochure_designandstyle_colour06.png',
			'lincoln-touchbrochure_designandstyle_colour07.png',
			'lincoln-touchbrochure_designandstyle_colour05.png',
			'lincoln-touchbrochure_designandstyle_colour02.png',
			'lincoln-touchbrochure_designandstyle_colour03.png',
			'lincoln-touchbrochure_designandstyle_colour04.png'
		]

		this.__construct();
	}

	App.prototype = {
		__construct: function() {
			this.createSlides();
			this.events();
			this.reset();
		},
		reset: function() {
			this.section = 0;
			this.slide = 0;
			this.colour = 0;

			$('.slideshow-nav, #core > div').hide();
			$('a#instructions, a#home').show();
			$('div#instructions').fadeIn();
		},
		events: function() {
			var scope = this;

			$('a').on('click', function(e) {
				e.preventDefault();
			});

			$('.colours a').on('click', function() {
				var id = $(this).attr('id');

				if (scope.slides[scope.section][scope.slide] == 'colours' && id != scope.colour) {
					scope.colour = id;
					scope.colourPick();
				}
			});

			$('a#home').on('click', function() {
				$('.slideshow-nav, #core > div').hide();
				$('a#instructions, a#home').show();
				$('div#home').fadeIn();
			});

			$('a#instructions').on('click', function() {
				scope.reset();
			});

			$('div#instructions a').on('click', function() {
				$('div#instructions').hide();
				$('div#home').fadeIn();
			});

			$('div#home a').on('click', function() {
				scope.section = $(this).attr('id');
				$('#home').hide();
				$('.slideshow-nav').show();
				scope.choice(true);
			});

			$('.slideshow-nav').on('click', function() {
				var id = $(this).attr('id');

				if (id == 'up') {
					scope.slide--;

					if (scope.slide < 0)
						scope.slide = scope.slides[scope.section].length - 1;

					if (scope.slides[scope.section].length == 1)
						return;
				} else if (id == 'right') {
					scope.section++;
					scope.slide = 0;

					if (scope.section >= scope.slides.length)
						scope.section = 0;
				} else if (id == 'down') {
					scope.slide++;

					if (scope.slide >= scope.slides[scope.section].length)
						scope.slide = 0;

					if (scope.slides[scope.section].length == 1)
						return;
				} else if (id == 'left') {
					scope.section--;
					scope.slide = 0;

					if (scope.section < 0)
						scope.section = scope.slides.length - 1;
				} else {
					return;
				}

				var isSection;

				if (id == 'left' || id == 'right')
					isSection = true;

				scope.choice(isSection);
			});
		},
		createSlides: function() {
			for (var section in this.slides) {
				$('#core').append('<div id="section-' + section + '" class="section">');
				var sectionContainer = $('#section-' + section);

				for (var slide in this.slides[section]) {
					var img = this.slides[section][slide];

					sectionContainer.append('<img src="assets/img/' + img + '" />');

					//create colour picker nav
					if (img == 'colours') {
						sectionContainer.addClass('colours').append('<div>').append('<ul>');

						for (var colour in this.colours) {
							sectionContainer.find('ul').append('<li><a href="" id="' + colour + '"></a></li>');

							var colour = this.colours[colour];

							sectionContainer.find('div').append('<img src="assets/img/' + colour + '" />');
						}
					}
				}
			}
		},
		choice: function(isSection) {
			if (isSection) {
				$('.section').stop(true, true).fadeOut(700);
				$('#section-' + this.section).stop(true, true).fadeIn(700);
			}

			$('.section img').stop(true, true).fadeOut();

			//not colour picker slide
			if (this.slides[this.section][this.slide] != 'colours') {
				$('.colours ul').hide();
				$('#section-' + this.section + ' img').eq(this.slide).stop(true, true).fadeIn();
			} else {
				$('.colours ul').show();
				this.colour = 0;
				this.colourPick();
			}
		},
		colourPick: function() {
			$('#section-' + this.section + ' div img').stop(true, true).fadeOut();
			$('#section-' + this.section + ' div img').eq(this.colour).stop(true, true).fadeIn();
		}
	};

	window.App = App;
})(jQuery, window);