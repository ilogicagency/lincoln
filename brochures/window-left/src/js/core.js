(function($) {
	$(document).ready(function() {
		new App();
	});
})(jQuery);

(function($, window) {
	function App() {
		this.section = 0;
		this.slide = 0;
		this.slides = [
			['lincoln-touchbrochure-design-exteriorleds.png', 'lincoln-touchbrochure-design-sidemirrors.png', 'lincoln-touchbrochure-design-splitgrille.png', 'lincoln-touchbrochure-design-therear.png'],
			['lincoln-touchbrochure-features-ambientlighting.png', 'lincoln-touchbrochure-features-drivestyle.png', 'lincoln-touchbrochure-features-pushshift.png', 'lincoln-touchbrochure-features-sync.png'],
			['lincoln-touchbrochure-performance-drivecontrol.png', 'lincoln-touchbrochure-performance-freestandingoptions.png', 'lincoln-touchbrochure-performance-handling.png', 'lincoln-touchbrochure-performance-performancespecs.png']
		];

		this.__construct();
	}

	App.prototype = {
		__construct: function() {
			this.events();
			this.createSlides();
			this.choice();
		},
		events: function() {
			var scope = this;

			$('a').on('click', function(e) {
				e.preventDefault();

				var id = $(this).attr('id');

				if (id == 'up') {

					scope.slide++;
					console.log(scope);

					if (scope.slide >= scope.slides[scope.section].length)
						scope.slide = 0;

				} else if (id == 'right') {

					scope.section++;
					console.log(scope);

					if (scope.section >= scope.slides[scope.section].length)
						scope.section = 0;

				} else if (id == 'down') {

					scope.slide--;
					console.log(scope);

					if (scope.slide <= 0)
						scope.slide = scope.slides[scope.section].length;

				} else if (id == 'left') {

					scope.section--;
					console.log(scope);

					if (scope.section <= 0)
						scope.section = scope.slides[scope.section].length;

				}
				//reset to zero if count up/down OR left/right reaches array limit
				scope.choice();
			});
		},
		createSlides: function() {
			for (var section in this.slides) {
				$('#core').append('<div id="section-' + section + '" class="section">');
				var sectionContainer = $('#section-' + section);

				for (var slide in this.slides[section]) {
					var imgName = this.slides[section][slide];

					sectionContainer.append('<img src="assets/img/' + imgName + '" />');
				}
			}
		},
		choice: function() {
			$('.section').hide();
			$('.section img').hide();

			$('#section-' + this.section).show();
			$('#section-' + this.section + ' img').eq(this.slide).fadeIn(1000);
		}
	};

	window.App = App;
})(jQuery, window);