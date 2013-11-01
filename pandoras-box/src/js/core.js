(function($, window) {
	$(document).ready(function() {
		window.app = new App();
	});
})(jQuery, window);

(function($, window) {
	function App() {
		this.sections = ['start', 'scenary', 'driveStyle', 'music', 'lighting'];
		this.sectionCurrent;
		this.choices = {
			Start: {seek: '00:00:00:00', delay: 1990},
			CapeTown: {seek: '00:01:00:00', delay: 1580},
			Dubai: {seek: '00:02:00:00', delay: 1580},
			France: {seek: '00:03:00:00', delay: 1580},
			London: {seek: '00:04:00:00', delay: 1580},
			CapeTownDriveStyle: {seek: '00:05:00:00', delay: 6100},
			CapeTownDriveStyleClassical: {seek: '00:06:30:00', delay: 3820},
			CapeTownDriveStyleClassicalEndeavour: {seek: '00:08:00:00', delay: 53500},
			CapeTownDriveStyleClassicalDesert: {seek: '00:09:30:00', delay: 53500},
			CapeTownDriveStyleClassicalCalypso: {seek: '00:11:00:00', delay: 53500},
			CapeTownDriveStyleJazz: {seek: '00:12:30:00', delay: 3820},
			CapeTownDriveStyleJazzEndeavour: {seek: '00:14:00:00', delay: 53500},
			CapeTownDriveStyleJazzDesert: {seek: '00:15:30:00', delay: 53500},
			CapeTownDriveStyleJazzCalypso: {seek: '00:17:00:00', delay: 53500},
			CapeTownDriveStyleArabic: {seek: '00:18:30:00', delay: 3820},
			CapeTownDriveStyleArabicEndeavour: {seek: '00:20:00:00', delay: 53500},
			CapeTownDriveStyleArabicDesert: {seek: '00:21:30:00', delay: 53500},
			CapeTownDriveStyleArabicCalypso: {seek: '00:23:00:00', delay: 53500},
			DubaiDriveStyle: {seek: '00:26:00:00', delay: 6100},
			DubaiDriveStyleClassical: {seek: '00:27:30:00', delay: 3820},
			DubaiDriveStyleClassicalEndeavour: {seek: '00:29:00:00', delay: 53500},
			DubaiDriveStyleClassicalDesert: {seek: '00:30:35:00', delay: 53500},
			DubaiDriveStyleClassicalCalypso: {seek: '00:32:00:00', delay: 53500},
			DubaiDriveStyleJazz: {seek: '00:33:30:00', delay: 3820},
			DubaiDriveStyleJazzEndeavour: {seek: '00:35:00:00', delay: 53500},
			DubaiDriveStyleJazzDesert: {seek: '00:36:30:00', delay: 53500},
			DubaiDriveStyleJazzCalypso: {seek: '00:38:00:00', delay: 53500},
			DubaiDriveStyleArabic: {seek: '00:39:30:00', delay: 3820},
			DubaiDriveStyleArabicEndeavour: {seek: '00:41:00:00', delay: 53500},
			DubaiDriveStyleArabicDesert: {seek: '00:42:30:00', delay: 53500},
			DubaiDriveStyleArabicCalypso: {seek: '00:44:00:00', delay: 53500},
			FranceDriveStyle: {seek: '00:47:00:00', delay: 6100},
			FranceDriveStyleClassical: {seek: '00:48:30:00', delay: 3820},
			FranceDriveStyleClassicalEndeavour: {seek: '00:50:00:00', delay: 53500},
			FranceDriveStyleClassicalDesert: {seek: '00:51:30:00', delay: 53500},
			FranceDriveStyleClassicalCalypso: {seek: '00:53:00:00', delay: 53500},
			FranceDriveStyleJazz: {seek: '00:54:30:00', delay: 3820},
			FranceDriveStyleJazzEndeavour: {seek: '00:56:00:00', delay: 53500},
			FranceDriveStyleJazzDesert: {seek: '00:57:30:00', delay: 53500},
			FranceDriveStyleJazzCalypso: {seek: '00:59:00:00', delay: 53500},
			FranceDriveStyleArabic: {seek: '01:00:30:00', delay: 3820},
			FranceDriveStyleArabicEndeavour: {seek: '01:02:00:00', delay: 53500},
			FranceDriveStyleArabicDesert: {seek: '01:03:30:00', delay: 53500},
			FranceDriveStyleArabicCalypso: {seek: '01:05:00:00', delay: 53500},
			LondonDriveStyle: {seek: '01:08:00:00', delay: 6100},
			LondonDriveStyleClassical: {seek: '01:09:30:00', delay: 3820},
			LondonDriveStyleClassicalEndeavour: {seek: '01:11:00:00', delay: 53500},
			LondonDriveStyleClassicalDesert: {seek: '01:12:30:00', delay: 53500},
			LondonDriveStyleClassicalCalypso: {seek: '01:14:00:00', delay: 53500},
			LondonDriveStyleJazz: {seek: '01:15:30:00', delay: 3820},
			LondonDriveStyleJazzEndeavour: {seek: '01:17:00:00', delay: 53500},
			LondonDriveStyleJazzDesert: {seek: '01:18:30:00', delay: 53500},
			LondonDriveStyleJazzCalypso: {seek: '01:20:00:00', delay: 53500},
			LondonDriveStyleArabic: {seek: '01:21:30:00', delay: 3820},
			LondonDriveStyleArabicEndeavour: {seek: '01:23:00:00', delay: 53500},
			LondonDriveStyleArabicDesert: {seek: '01:24:30:00', delay: 53500},
			LondonDriveStyleArabicCalypso: {seek: '01:26:00:00', delay: 800}
		}
		this.userChoices;
		this.queue;
		this.chosen;
		this.timer;
		this.trafficTimer;
		this.blisTimer;
		this.laneTimer;
		this.noiseTimer;
		this.parkTimer;
		this.debugEnabled = false;

		this.__construct();
	}

	App.prototype = {
		__construct: function() {
			if (typeof PBAutoCommands == 'undefined' && this.debugEnabled)
				debug.output('Unable to find Pandoras Box command: "PBAutoCommands"!');

			if (this.debugEnabled)
				window.debug = new Debug();

			this.timer = new Timer();
			this.trafficTimer = new Timer();
			this.blisTimer = new Timer();
			this.laneTimer = new Timer();
			this.noiseTimer = new Timer();
			this.parkTimer = new Timer();
			this.gifTimer = new Timer();

			this.keepAlive();
			this.events();
			this.reset();
		},
		events: function() {
			var scope = this;

			$(window).on('blur', function() {
				if (scope.debugEnabled)
					debug.output('[Browser lost focus]');

				scope.pause();
			});

			$('.selection').on('click', function(e) {
				e.preventDefault();

				scope.destroyTimers();

				if (scope.sectionCurrent == 2) {
					scope.trafficTimer.start(12000, scope.videoPlay, scope, {video: 'cross-traffic'});
					scope.blisTimer.start(30000, scope.videoPlay, scope, {video: 'blis'});
				}

				if (scope.sectionCurrent == 3) {
					scope.laneTimer.start(16000, scope.videoPlay, scope, {video: 'lane-keeping'});
				}

				if (scope.sectionCurrent == 4) {
					scope.noiseTimer.start(2000, scope.videoPlay, scope, {video: 'noise-control'});
					scope.parkTimer.start(30000, scope.videoPlay, scope, {video: 'park-assist'});
				}

				scope.choiceMade($(this), scope);
			});
		},
		videoPlay: function(scope, args) {
			var duration = args.duration == undefined ? 10500 : args.duration;
			var date = new Date();
			var uncache = date.getMilliseconds();

			$('#' + args.video).fadeIn(1000);

			var img = $('#' + args.video).find('img');

			img.attr('src', img.attr('data-src') + '#' + uncache);

			scope.gifTimer.destroy();
			scope.gifTimer.start(duration, scope.videoEnded, scope, {video: args.video});
		},
		videoEnded: function(scope, args) {
			$('#' + args.video).fadeOut(1000);
		},
		choiceMade: function(element, scope) {
			var container = element.closest('.container');
			var id = element.find('img').attr('alt');
			var choice = id.replace(/ /g, '');

			container.hide();

			$('body').removeClass();

			if (id != 'Start') {
				scope.userChoices.push(id);
				$('body').addClass('transition');
			} else {
				$('body').addClass('blank');
			}

			if (scope.userChoices.length > 1) {
				choice = scope.userChoices.join().replace(/\,/g, '').replace(/ /g, '');

				choice = choice.replace(/Normal/g, 'DriveStyle');
				choice = choice.replace(/Comfort/g, 'DriveStyle');
				choice = choice.replace(/Sport/g, 'DriveStyle');
			}

			var delay = scope.choices[choice].delay;

			scope.sectionCurrent++;

			scope.timer.start(delay, scope.selection, scope);

			var seek = scope.choices[choice].seek;
			var hour = seek.substring(0, 2);
			var min = seek.substring(3, 5);
			var sec = seek.substring(6, 8);
			var frame = seek.substring(9, 11);

			if (typeof PBAutoCommands != 'undefined') {
				PBAutoCommands.moveSequenceToTime(false, 1, hour, min, sec, frame);
				PBAutoCommands.setSequenceTransportMode(false, 1, 'Play');

				if (this.debugEnabled)
					debug.output(' - PB play');
			}

			if (scope.debugEnabled) {
				debug.output(' - Choice: ' + id);
				debug.output(' - Scenario: ' + choice);
				debug.output(' - Play');
			}
		},
		selection: function(scope) {
			scope.destroyTimers();

			if (scope.sectionCurrent != scope.sections.length) {
				$('body').removeClass().fadeIn(2000);
				$('body').addClass(scope.sections[scope.sectionCurrent]);

				$('#' + scope.sections[scope.sectionCurrent]).fadeIn(2000);

				if (scope.debugEnabled)
					debug.output('Choosing: ' + scope.sections[scope.sectionCurrent]);
			}

			scope.pause();

			if (scope.sectionCurrent == scope.sections.length) {
				if (scope.debugEnabled) {
					debug.output('-----------------------------------------------------------');
					debug.output('User scenary: ' + scope.userChoices[0]);
					debug.output('User drive style: ' + scope.userChoices[1]);
					debug.output('User music: ' + scope.userChoices[2]);
					debug.output('User lighting: ' + scope.userChoices[3]);
					debug.output('-----------------------------------------------------------');
				}

				if (!scope.debugEnabled)
					setTimeout(function() {
						window.location = server + 'book.php?choices=' + '{"scenary": "' + scope.userChoices[0] + '", "driveStyle": "' + scope.userChoices[1] + '", "music": "' + scope.userChoices[2] + '", "lighting": "' + scope.userChoices[3] + '"}';
					}, 1000);
			}
		},
		reset: function() {
			this.sectionCurrent = 0;
			this.userChoices = [];

			this.destroyTimers();

			$('#start').fadeIn(2000);
			$('body').addClass('start');

			if (typeof PBAutoCommands != 'undefined') {
				PBAutoCommands.moveSequenceToTime(false, 1, 0, 0, 0, 0);
				PBAutoCommands.setSequenceTransportMode(false, 1, 'Stop');
			}

			if (this.debugEnabled)
				debug.output('Choosing: ' + this.sections[this.sectionCurrent]);
		},
		destroyTimers: function() {
			this.timer.destroy();
			this.trafficTimer.destroy();
			this.blisTimer.destroy();
			this.laneTimer.destroy();
			this.noiseTimer.destroy();
			this.parkTimer.destroy();
			this.gifTimer.destroy();
		},
		pause: function() {
			if (typeof PBAutoCommands != 'undefined') {
				PBAutoCommands.setSequenceTransportMode(false, 1, 'Pause');

				if (this.debugEnabled)
					debug.output(' - PB paused');
			}

			if (this.debugEnabled)
				debug.output(' - paused');
		},
		keepAlive: function() {
			var scope = this;
			var url = pandora + 'src/keepAlive.js';

			$.ajax({
				type: "GET",
				url: url
			}).done(function() {
				setTimeout(function() {
					scope.keepAlive();
				}, 2000);
			}).fail(function() {
				if (scope.debugEnabled)
					debug.output('Unable to ping URL: ' + url);
			});
		}
	};

	window.App = App;
})(jQuery, window);

(function(window) {
	function Timer() {
		this.timer;
	}

	Timer.prototype = {
		start: function(delay, callback, scope, args) {
			this.destroy();

			this.timer = setTimeout(function() {
				callback(scope, args);
			}, delay);
		},
		destroy: function() {
			clearInterval(this.timer);
		}
	};

	window.Timer = Timer;
})(window);

(function($, window) {
	function Debug() {
		$('body').prepend('<div id="debug">');
		$('#debug').css('position', 'absolute').css('top', 0).css('padding', 10).css('z-index', 9999).css('height', '90%').css('overflow', 'auto').css('background', '#666').css('white-space', 'nowrap').css('font-size', 10);
	}

	Debug.prototype = {
		output: function(text) {
			var html = $('#debug').html() != '' ? $('#debug').html() : '';

			$('#debug').html(html + '<div>' + text + '</div>');
		}
	};

	window.Debug = Debug;
})(jQuery, window);