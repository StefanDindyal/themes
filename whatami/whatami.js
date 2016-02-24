(function($){

	var words = {
		'verbAdjective':[
			'working',
			'disgraced',
			'foolish',
			'winning',
			'losing',
			'flying',
			'defiled',
			'fat',
			'skinny',
			'wide',
			'thin',
			'silky',
			'rough',
			'burning',
			'cold',
			'crippled',
			'unbecoming',
			'beautiful',
			'ugly',
			'lazy',
			'energetic',
			'blazing',
			'powerful',
			'weak',
			'lascivious',
			'punished',
			'solid'
		],
		'noun': [
			'pencil',
			'ass',
			'hat',
			'rack',
			'table',
			'chair',
			'cow',
			'lamp',
			'magnet',
			'star',
			'quasar',
			'potato',
			'carrot',
			'banana',
			'whip',
			'soda',
			'fish',
			'cat',
			'dog',
			'horse',
			'dolphin',
			'elephant',
			'ginger',
			'monkey',
			'donkey'
		]
	};

	function whatami(list){
		var self = this;
		this.words = list;
		this.verbAdjective = null;
		this.firstNoun = null;
		this.secondNoun = null;

		function init(){			
			$('#whatami .action button').on('click', self.button);
		}
	

		this.selectVerbAdjective = function(){
			var array = self.words.verbAdjective;
			var rand = array[Math.floor(Math.random() * array.length)];
			self.verbAdjective = rand;
		}

		this.selectNoun = function(){
			var array = self.words.noun;
			var rand = array[Math.floor(Math.random() * array.length)];
			var index = array.indexOf(rand);

			self.firstNoun = rand;

			rand = array[Math.floor(Math.random() * array.length)];

			while(self.firstNoun == rand){
				rand = array[Math.floor(Math.random() * array.length)];
				console.log(rand);			
			}
			
			self.secondNoun = rand;
		}

		this.button = function(){

			self.selectVerbAdjective();
			self.selectNoun();

			var a = self.verbAdjective;
			var b = self.firstNoun;
			var c = self.secondNoun;
			var put = $('#whatami .answer strong');
			var string = a + ' ' + b + ' ' + c;
			put.text(string);

			$('#whatami .answer').slideDown(300);

			return false;
		}	

		init();	
	}

	var ask = new whatami(words);

})(jQuery);