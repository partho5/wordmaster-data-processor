<?php

namespace App\Http\Controllers\Contents;

use App\Http\Controllers\Library;
use App\Http\Controllers\Processor\ImageProcessor;
use App\Models\Meanings;
use App\Models\PartsOfSpeech;
use App\Models\Words;
use App\Models\WordUsages;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait SocialMediaPostContents{

    private $hashTagsForWordPost = "#JobVocabulary #vocabulary #bcs #bank #BangladeshBank #PrivateBank";


    function getContentsOfType($postType){
        $contents = [];
        if($postType == 'words'){
            //word with meanings. Only plain text will be posted
            //here return only the word. Rest of the data will be queried later
            $contents = $this->mainWords;
        }
        else if($postType == 'triggerPeople'){
            //post things which triggers people to react/comment
            $contents = $this->content_triggerPeople();
        }
        else if($postType == 'funnyRelevant'){
            //funny content but somewhat relevant to our page topic

        }
        else if($postType == 'meme'){
            //should be self created memes. copied memes get less impression

        }
        else if($postType == 'translation'){
            //translation practice

        }
        else if($postType == 'others'){
            //e.g. explanation of a word, phrase, common mistakes in English etc..

        }

        return $contents;
    }

	function content_triggerPeople(){
		return [
			"আমি তো আমি ই - এর English কি হবে ?",
			"কী খবর ? যাও কই - এর English কি হবে ?",
			"word এর শেষে ly থাকলেই adverb হবে এমন কোন কথা নাই । manly কিন্তু adjective.\nby the waw \"manly\" এর অর্থ বোঝেন তো :D ?"
		];
	}

	function content_words(){
		return [
			"1No Abound - প্রাচুর্যপূর্ণ হওয়া\nabound : bound >> boundary , এত বেশি পরিমাণ যার কোন boundary/সীমানা নেই। অর্থাৎ প্রচুর পরিমাণে থাকা",
            "2No abrasive - 1. যা দিয়ে কোন কিছু ঘষে তোলা হয়\n2. (আচরণ বোঝাতে)  রূঢ় বা রুক্ষ টাইপের\nabrasive : bras >> brash , ব্রাশ দিয়ে তো ঘষামাজার কাজ করার হয়, তাই ব্রাশ এক ধরনের abrasive জিনিস",
            "3No abridge - সংক্ষিপ্ত করা\nabridge : নদীতে bridge (ব্রিজ) দেওয়া হয় রাস্তা সংক্ষিপ্ত করার জন্য । So abridge মানে সংক্ষিপ্ত করা"
		];
	}



	function content_funnyRelevant(){
		return [
			"hi"
		];
	}




	function content_others(){
	    return [
	        ""
        ];
    }


    public $mainWords = ["abandon","abase","abash","abate","abdicate","aberration","abet","abeyance","abhor","abject","abjure","abnegate","abnormality","abolish","abominate","aboriginal","abortive","abound","abrasive","abridge","abrogate","abrupt","absconder","absolve","absolute","abstinent","abstract","abstruse","absurd","abundant","abuse","abysmal","accede","accent","accentuate","access","accessory","acclaim","accolade","accommodate","accomplice","accomplish","accord","accost","accountability","accouterments","accretion","accrue","accumulate","accuse","accustom","acerbic","acme","acquaint","acquiesce","acquisitive","acquit","acrid","acrimonious","acronym","acumen","acute","ad-lib","adage","adamant","adapt","addendum","address","adduce","adept","adhere","adherent","adieu","adjacent","adjourn","adjudicate","adjunct","adjutant","adjuvant","admonish","adorn","adroit","adulation","adulterate","advent","adventitious","adverse","advertent","advocate","aesthetic","affable","affectation","affidavit","affiliate","affinity","affix","affliction","affluent","afford","affront","aftermath","agenda","agglomerate","aggrandize","aggravate","aggregate","aggrieve","aghast","agile","agitate","agnostic","agony","agrarian","ail","akin","alacrity","alchemy","alienate","alight","allay","allege","allegiance","allegory","alleviate","alliance","allocate","allot","allowance","alloy","allure","allusion","ally","aloof","aloud","alteration","altercation","altruism","amalgamate","amass","amateur","amatory","ambidextrous","ambience","ambiguous","ambit","ambivalent","ambush","ameliorate","amenable","amend","amenity","amiable","amicable","amid","amiss","amity","amnesty","amoral","amorous","amorphous","ample","amuse","anachronism","analgesic","analogy","anarchy","anathema","ancestor","ancillary","anecdote","angst","anguish","animosity","annal","annex","annihilate","annuity","annul","anodyne","anomaly","antagonist","antecedent","antedate","anterior","anthology","anthropology","anthropomorphic","antidote","antipathy","antipodal","antique","antiquated","antiquity","antithesis","apartheid","apathetic","apathy","aperture","apex","aphorism","apocalyptic","apocryphal","apogee","apoplexy","apostasy","apothegm","apotheosis","appall","apparition","appease","appellation","appendage","applaud","apportion","apposite","appraise","appreciate","apprehend","apprehensive","apprise","approbation","appropriate","appurtenance","apropos","apt","aptitude","aquaculture","arbiter","arbitrary","arcade","arcane","archaic","archetype","archipelago","archives","ardor","ardent","arduous","argot","arid","aristocratic","armament","armistice","aroma","arraign","arrant","arrears","arsenal","artful","articulate","artifice","artillery","artisan","ascend","ascendancy","ascertain","ascetic","ascribe","asinine","askance","askew","aspersion","aspire","assail","assault","assemble","assent","assert","assertive","assess","assiduous","assimilate","assuage","astounding","astray","astringent","astute","asylum","atheist","atone","atrocious","atrophy","attenuate","attest","attribute","attrition","audacity","augment","augur","august","auspices","auspicious","austere","autocratic","autonomous","auxiliary","avail","avarice","aver","aversion","avert","avid","avow","avuncular","awry","bacchanal","axiom","baffle","baleful","balk","ballyhoo","balm","balmy","banal","bandy","bane","banish","banquet","banter","bar","barb","baroque","barrage","barren","barter","basilica","bastion","bauble","bedlam","beget","begrudge","behest","belabor","beleaguer","belie","belittle","bellicose","belligerent","bemoan","bemused","benchmark","benediction","benefactor","benevolent","benighted","benign","bent","bequeath","bequest","berate","bereaved","bereft","beset","besiege","besmirch","bestow","beverage","bewail","bewilder","bias","bifurcate","bilious","biting","bitter","bivouac","bizarre","blanch","bland","blandishment","blasphemy","blast","blatant","blather","blaze","blend","blight","bliss","blithe","bloc","blunder","blunt","blurry","bluster","boffin","bogus","bolster","bombast","bona fide","bon vivant","boon","boor","booty","botch","bounty","bourgeois","bovine","boycott","bracing","brag","brandish","bravado","brawl","brawn","brazen","breach","bred","breeze","brevity","brink","brisk","bristle","brittle","broach","brochure","bromide","brood","brouhaha","brusque","brutal","buckle","bucolic","buffoon","bully","bulwark","bump","bungle","buoyant","bureaucracy","burgeon","burglary","burlesque","bustle","buttress","byzantine","cabal","cache","cacophony","cadence","cajole","calamity","callous","callow","calumniate","calumny","candid","candor","canny","canorous","canon","cant","cantankerous","canvass","capacious","capitalism","capital","capitulate","capricious","captivate","carcinogenic","cardinal","careen","caricature","carnivorous","carouse","cartography","carve","cascade","cast","castigate","casual","casualty","cataclysm","catalyst","catastrophic","categorical","catharsis","catholic","caucus","caustic","cavalier","cavil","cease","cede","celibacy","cellar","cemetery","censor","censorious","censure","centenary","cerebral","chafe","chaff","chagrin","chameleon","champion","channel","charisma","charlatan","chary","chase","chasm","chaste","chasten","chastise","chauvinism","cheek","cherish","cherub","chicanery","chide","chill","chimera","chivalrous","choleric","chortle","chronic","chronicle","chronological","chummy","churl","churlish","chutzpah","cipher","circuitous","circumlocution","circumnavigate","circumscribe","circumspect","circumvent","citadel","civil","clamor","clandestine","clasp","classic","cleanse","cleave","clemency","clerical","cliche","cliff","climatic","climax","clique","clobber","cloister","clone","clout","clown","cloy","clumsy","clutter","coalesce","coalition","coarse","coax","cocky","coddle","coerce","coffers","cogent","cogitate","cognitive","cognizant","coherent","cohort","colloquial","collusion","colonel","colossal","combat","comely","commemorate","commence","commend","commensurate","commentary","commiserate","commit","commodious","commonplace","commotion","compassion","compatible","compel","compelling","compendium","competent","compile","complacent","complaint","complaisance","complement","complicity","compliment","comply","comport","composed","comprehensive","comprise","compromise","compulsive","compunction","concise","concurrent","concave","conman","concatenate","conceal","concede","conceit","conceive","concentric","concert","concession","concierge","conciliate","conciliatory","conclusive","concoct","concomitant","concord","concourse","concrete","condemn","condescend","condole","condone","conducive","confederate","confer","confidant","confidential","configuration","confine","confiscate","conflagration","confluence","conform","conformist","confound","confront","congeal","congenial","congenital","congest","congregate","congruence","conjecture","conjugal","conjure","connate","connive","connoisseur","connote","conscientious","consecrate","consensus","consent","conservatory","considerate","consign","consistent","consolidate","consonant","conspicuous","consternation","constituency","constrain","construe","consummate","contain","contemplate","contempt","content","contention","contentious","contiguous","continence","contingent","continuum","contraband","contract","contravene","contretemps","contrite","contrive","contrived","controversy","contumacious","contumely","conundrum","convene","conventional","conversant","converse","convey","conviction","convivial","convolution","convulse","copious","cordial","corollary","corporal","corporeal","corpulent","correlation","corroborate","corrosive","corrugated","cosmopolitan","coterie","countenance","counteract","counterfeit","counterpart","coup","courteous","covenant","covert","covet","cower","cozy","cranky","crass","crave","craven","credence","credulous","crescendo","crest","crestfallen","crevice","cringe","criterion","critique","crook","crucial","crumble","crux","cryptic","cue","cuisine","culinary","cull","culminate","culpable","cult","cumbersome","cupidity","curative","curator","curb","curl","curmudgeon","cursory","curt","curtail","cusp","customary","cynic","dabble","daft","dally","dam","damp","daunt","dawdle","dazzle","deaden","dearth","debacle","debar","debase","debauchery","debilitate","debonair","debris","debunk","decadent","decay","deceit","decent","deception","deciduous","decimate","decisive","decompose","decorous","decree","decrepit","decry","deduce","deem","deface","defame","defendant","defer","deference","deficiency","deficit","defile","definitive","defrost","deft","defunct","defy","degenerate","degrade","deification","deign","deject","delate","deity","dejected","delectable","delegate","deleterious","deliberate","delightful","delineate","delinquent","deliverance","delude","deluge","delve","demagogue","demarcate","demean","demeanor","demise","demography","demolish","demur","demure","denigrate","denizen","denomination","denote","denounce","dent","depict","deplete","deplore","deploy","deport","depose","depravity","deprecate","depreciate","depredate","deprive","derelict","deride","derogatory","descend","descendant","desecrate","desiccate","designate","desist","desolate","despair","despise","despondent","despot","dessert","destitute","desultory","detain","detente","deter","deteriorate","detest","detract","devious","devise","devour","devout","dexterous","dialectical","diaphanous","diatribe","dichotomy","dictatorial","dictum","didactic","diffident","diffuse","digress","dilapidated","dilate","dilemma","dilettante","diligent","dilute","dim","diminish","diminution","din","dire","dirge","disaffect","disarray","disavow","disband","disburse","discern","disciple","disclaim","discomfit","disconcert","discord","discourse","discourteous","discreet","discrepancy","discrete","discriminate","discursive","disdain","disencumber","disentangle","disgrace","disgruntle","dishearten","disincentive","disinformation","disinterested","dismal","dismantle","dismay","dismiss","disparage","disparate","dispassionate","dispatch","dispel","dispense","disperse","dispirit","disposition","disproportionate","disprove","dispute","disquiet","disrupt","dissect","dissemble","disseminate","dissent","dissertation","disservice","dissident","dissipate","dissociate","dissolution","dissolve","dissonant","dissuade","distend","distinct","distinguish","distort","ditch","dither","diurnal","divergence","divine","divisive","divulge","docile","doctrinaire","doctrine","document","dodge","dogged","dogmatic","doldrums","doleful","dolt","domestic","dormant","dotage","double entendre","dour","douse","downcast","downplay","dozy","drab","draconian","dreadful","dreary","drench","droll","dross","drown","drowsy","drudgery","dubious","dunce","dupe","duplicity","duress","dwindle","earnest","easygoing","ebb","ebullient","eccentric","ecclesiastical","eclectic","eclipse","economize","ecosystem","ecstasy","edgy","edict","edifice","edify","eerie","efface","effectual","efficacy","effigy","effrontery","effusion","effusive","egalitarian","egocentric","egotistical","egregious","egress","elan","elation","electorate","elegy","elicit","elliptical","elite","elocution","elongate","elucidate","elusive","emaciate","emanate","emancipate","embargo","embark","embellish","embezzlement","emblem","embody","embrace","embroil","embryonic","emigrate","eminent","emissary","empathy","empirical","empower","emulate","encompass","encroach","encumber","endear","endemic","endorse","enervate","enfranchise","engaging","engender","engross","engulf","enigma","enmity","ennui","enormity","enrage","ensue","entail","entangled","entendre","enthralling","entice","entitle","entity","entrance","entreat","entrench","entrepreneur","enumerate","envious","envision","ephemeral","epicure","epigram","epilogue","episodic","epithet","epitome","epoch","equanimity","equestrian","equitable","equivocal","erect","ergonomic","errand","errant","erudite","eschew","escort","esoteric","espouse","essence","estimable","estrange","eternal","ethereal","ethics","ethnic","ethos","etiquette","eulogy","euphemism","euphony","euphoria","evade","evaluation","evanescent","evasive","evict","evident","evince","evoke","exacerbate","exacting","exalt","exasperate","excel","excise","exculpate","excursion","execrate","exemplary","exemplify","exempt","exert","exhaustive","exhilarate","exhort","exhume","exigency","exiguous","exile","existential","exodus","exonerate","exorbitant","exotic","expatriate","expedient","expedite","expiate","explicate","explicit","exposition","expostulate","expunge","exquisite","extant","extemporize","extenuate","exterminate","extol","extort","extraneous","extrapolate","extravagant","extremity","extricate","extrovert","exuberant","exult","fabrication","fabulous","facade","facet","facetious","facile","faction","factual","faint","fallacy","fallibility","falter","fanatic","fantasy","farcical","fasten","fastidious","fatalist","fathom","fatigue","fatuous","fauna","faux","fawn","feasibility","fecund","federation","feeble","feign","feisty","felicity","fend","fervent","fervor","fester","fetid","fetish","fetter","fiasco","fiat","fickle","fictitious","fidelity","fierce","figment","figurative","filthy","finesse","finicky","fiscal","flagrant","flair","flamboyant","flashy","flattery","flaunt","flawless","fledgling","flee","fleeting","flimsy","fling","flippant","floppy","flora","florid","flourish","flout","flurry","fodder","foible","foil","folly","foment","foolhardy","foray","forbear","forbearance","forebode","foreclose","forego","forensic","forerunner","foresee","forestall","forfeit","forge","formidable","forsake","forswear","forte","forthright","fortify","fortress","fortuitous","foster","founder","fracture","fragile","fragmentary","fragrance","franchise","frantic","fraternal","fraudulence","frenetic","frenzied","fretful","friable","fringe","frivolity","frontier","frugal","fruitful","fruition","fuel","fulminate","furious","furtive","fusion","futile","fuzzy","gaffe","gaiety","gainsay","gala","gall","gallant","galvanize","gambit","gamut","gargantuan","garish","garner","garrison","garrulous","gastronomy","gauche","gaudy","gawky","generic","generosity","genesis","genial","genocide","genre","genteel","gentry","germane","gesticulate","ghastly","gibberish","glacier","glamour","glaring","glean","glimpse","glitch","gloomy","glorify","gloss","glut","gluttonous","gourmet","gracious","granary","grandeur","grandiloquent","grandiose","grapple","grasp","gratify","gratis","gratuitous","gravity","gregarious","grievous","grimace","grind","grip","gritty","grouchy","groveling","grudge","gruelling","gruesome","grumble","grumpy","guile","guise","gullible","habituate","hackneyed","haggle","halcyon","hallow","hallucination","haphazard","hapless","harass","harbinger","harbor","harp","harry","harsh","hasty","hazardous","hazy","headlong","heartfelt","heckle","hectic","hedonism","heedless","hegemony","heinous","heist","herald","heresy","hermetic","hesitant","heterogeneous","hew","heyday","hiatus","hideous","hierarchy","hilarious","histrionic","hoary","hoist","hollow","homage","homely","homestead","homicide","homily","homogeneous","hoodwink","hospice","hostile","hub","hubbub","hubris","humane","humanitarian","humdrum","humility","hurdle","hurl","husbandry","hyperbole","hypocrisy","iconoclast","hypothetical","ideology","idiom","idiosyncrasy","idyllic","ignominy","illicit","illustrious","imbue","imitate","immaculate","immanent","immensity","immerse","immigrate","imminent","immodest","immutable","impair","impartial","impasse","impassive","impeach","impeccable","impecunious","impede","impel","impending","impenetrable","imperative","imperial","imperil","imperious","impermeable","impertinence","imperturbable","impervious","impetuous","impinge","implacable","implement","implicate","implication","implore","importune","imposing","imposter","impotent","impoverish","impoverished","impregnable","impresario","impressionable","impromptu","impropriety","improvise","impudent","impugn","impulsive","impunity","impute","inadvertent","inalienable","inane","inapt","inaugurate","inbred","incandescent","incantation","incarnation","incendiary","incense","inception","incessant","incipient","incise","incisive","incite","inclemency","inclination","inconclusive","incongruous","inconsequential","incorporate","incorrigible","increment","incriminate","incubation","inculcate","incumbent","incursion","indecisive","indefatigable","indemnify","indict","indifferent","indigenous","indigent","indignant","indiscreet","indispensable","indisposition","indolent","indomitable","induce","indulge","indulgent","inebriety","ineffable","ineluctable","inept","ineradicable","inert","inevitable","inexorable","inexplicable","infamous","infatuated","infect","infer","infiltrate","infinitesimal","infirmity","inflammatory","inflate","inflection","inflict","influx","infraction","infrastructure","infringe","infuriate","infuse","ingenious","ingenuous","ingrained","ingratiate","inherent","inhibit","inhumane","inimical","inimitable","iniquitous","injunction","innate","innocuous","innuendo","inordinate","inquisition","insatiable","inscrutable","insidious","insight","insinuate","insipid","insolent","insouciant","instance","instate","instigate","instinct","insubordinate","insufferable","insular","insuperable","insure","insurgent","insurrection","integral","integrate","intelligible","intemperate","intensive","intercession","interdict","interim","interloper","interlude","interminable","intermittent","intersperse","interstellar","intervene","intimate","intimidate","intractable","intransigent","intricate","intrigue","intrinsic","introspective","intrude","inundate","inure","invade","invective","inveigle","inveterate","invidious","invigilate","invigorate","invincible","inviolate","invoke","irascible","ire","iridescent","irksome","ironic","irradiate","irresolute","irrevocable","irritable","isolate","itinerant","jaded","jargon","jaundiced","jaunt","jealous","jeer","jeopardy","jerk","jest","jingoism","jitter","jocular","jolly","jovial","jubilation","judicious","jumble","junction","junkie","junta","justifiable","juxtapose","karma","kinetic","knave","kudos","labyrinth","lackadaisical","lackluster","laconic","lament","lampoon","languish","larceny","largess","lascivious","latent","laud","lavish","lax","layman","legacy","lenient","lethargy","levity","liaison","libel","licentious","limpid","linger","listless","litany","lithe","litigate","livid","loath","lobby","logistics","loiter","loquacious","lousy","lout","lucid","lucrative","ludicrous","lugubrious","lull","luminous","lurk","lyrical","machiavellian","machination","magnanimous","magnate","magnificent","maladroit","malady","malaise","malapropism","malevolent","malfeasance","malicious","malignant","malinger","malleable","mandate","mania","manifest","manifesto","mar","marginal","marshal","martial","martyr","massive","materialistic","matriculate","maudlin","maverick","mawkish","maxim","maze","meager","meander","meddle","mediate","medication","mediocre","medium","meek","melancholy","meld","melee","mellifluous","menace","menagerie","mendacious","mendicant","mentor","mercenary","mercurial","mesmeric","metamorphosis","meticulous","microcosm","milieu","millennium","minuscule","minutiae","mire","misanthrope","misanthropic","misdemeanor","mishap","misogynist","mitigate","mock","mode","modest","modulate","moist","mollify","momentum","monetize","monolithic","monstrous","moratorium","mores","moribund","morose","mortify","motif","motley","mountebank","muddle","mudslinging","mull","multitudinous","mundane","municipal","munificent","murky","muscular","muse","mushroom","muster","myopia","myriad","mystic","mystique","nadir","naive","narcissism","nasty","nebulous","nefarious","nemesis","neologism","neophyte","nepotism","nettle","niche","nihilism","nimble","nirvana","noisome","nomadic","nominal","nomenclature","nonchalant","nonentity","nostalgia","notorious","novel","noxious","nuance","nuisance","nullify","numbness","nuptial","oaf","obdurate","obeisance","obfuscate","objective","oblique","obliterate","oblivion","obnoxious","obscure","obsequious","obsess","obstinate","obstreperous","obtrusive","obtuse","obviate","occult","odious","odyssey","officious","olfactory","oligarchy","omen","ominous","omnipresent","omniscient","onerous","onslaught","opaque","oppressive","opprobrious","opulent","orator","ordeal","ordinance","ornate","orphanage","orthodox","osmosis","oscillate","ostensible","ostentatious","ostracize","oust","outmaneuver","outrageous","outre","outspoken","overhaul","override","overstate","overt","overture","overwhelm","oxymoron","pacify","painstaking","palace","palatable","palisade","palliate","pallor","palpable","paltry","panacea","pandemic","panegyric","parable","paradigm","paradox","paragon","parallel","paranoia","paranormal","parasite","parched","parochial","parody","paroxysm","parsimonious","part","partisan","partition","pastoral","patent","paternal","pathology","pathos","patina","patriarch","patrician","patrimony","patronize","paucity","pauper","peasantry","peccadillo","peculiar","pedagogue","pedantic","pedestrian","peevish","pejorative","penchant","penitent","pensive","penurious","perceptible","peregrination","peremptory","perennial","perfidy","perfunctory","peril","peripatetic","periphery","perish","perjury","perk","permeate","pernicious","perpetrator","perpetuate","perplex","perquisite","persecute","perseverance","persistent","perspicuous","persuasive","pert","pertinent","perturb","peruse","pervade","pervasive","perverse","pessimistic","pest","petty","petulant","phantasm","philanthropy","philistine","phlegmatic","phony","piety","pilferage","pilgrim","pilgrimage","pillage","pine","pinnacle","pious","piquant","pitfall","pithy","pivotal","placate","placebo","placid","plagiarism","plague","plaintive","plaque","platitude","platonic","plausible","plead","plebeian","pledge","pleonasm","plethora","pliable","plight","plot","ploy","pluck","plumbing","plummet","plunder","pluralism","plutocrat","poignant","poise","polarize","polemic","pompous","ponder","ponderous","pontificate","porous","portend","portent","portray","posterity","posthumous","postulate","posture","potent","pragmatic","praiseworthy","prattle","precedent","precipitous","preeminent","preach","precarious","precede","precept","precipitate","precis","precise","preclude","precocious","precursor","predatory","predecessor","predestination","predicament","predilection","predispose","predominant","preempt","pregnant","prejudice","prejudicial","prelude","premeditated","premise","preponderance","prerogative","presage","prescient","presentiment","preserve","presumably","presuppose","pretend","pretext","prevail","prevalent","primal","pristine","privation","privy","probity","proceedings","proclaim","proclivity","procrastinate","procure","prod","prodigal","prodigious","prodigy","profane","profess","proficient","profligate","profound","profuse","progeny","prohibit","proletariat","proliferate","prolific","prolix","prologue","prom","prominent","promising","promulgate","propagate","propel","propensity","prophesy","propinquity","propitiate","propitious","proponent","propound","proprietary","propriety","propulsion","prosaic","proscribe","prosecute","proselytize","prospect","protagonist","protean","protege","protocol","protract","provident","provincial","provisional","provoke","prowess","proximity","prudent","prurient","pseudonym","psyche","pugnacious","puissance","pulverize","pummel","punctilious","pundit","pungent","punitive","purblind","purge","puritanical","purloin","purport","purported","pursuit","pusillanimous","putative","putrid","quaint","qualify","qualitative","quandary","quasi","quay","queer","quell","quench","querulous","query","questionnaire","queue","quibble","quiescent","quintessential","quixotic","quizzical","quotidian","rabble","radiant","rage","raid","ramble","ramification","rampant","rancor","rapacious","rapport","rapture","rarefied","ratify","ratiocination","rationale","raucous","ravage","ravenous","ravine","raze","reactionary","readiness","rear","rebellion","rebuff","rebuke","rebut","recalcitrant","recant","recapitulate","recede","receptacle","recidivism","reciprocal","reciprocate","reckless","reclaim","reclusive","recoil","recollect","recompense","reconciliation","recondite","recount","recourse","recrimination","rectify","rectitude","recuperate","redeem","redolent","redoubtable","redress","redundant","reek","referendum","reflective","refractory","refrain","refute","regal","regime","regimen","rehabilitation","rehearse","reign","rein","reinforce","reinstate","reiterate","rejoice","rejoinder","relegate","relentless","relic","relinquish","relish","relive","remarkable","remedial","reminiscent","remiss","remission","remnant","remonstrate","remorse","remuneration","renaissance","rend","render","renounce","renovate","renowned","reparation","repartee","repeal","repentant","repercussion","replenish","replete","replicate","repose","reprehensible","repress","reprimand","reprisal","reproach","reprobate","reprove","repudiate","repugnant","repulsive","requisite","rescind","resemblance","resent","residue","resignation","resilient","resolute","resolve","respite","resplendent","restitution","restrain","resurgence","resurrection","retain","retaliation","retention","reticent","retort","retract","retreat","retrospect","revamp","revel","reverberation","revere","revert","revile","revive","revoke","revolt","revulsion","rhapsodize","rhetoric","ribald","ridicule","rife","righteousness","rigorous","rim","risque","rite","rival","rivet","robust","rogue","rosy","rouse","rout","rudimentary","rue","ruffle","rugged","ruminate","rupture","ruse","rustic","ruthless","sabotage","saccharine","sacred","sacrilege","sacrosanct","sagacious","salient","sally","salutary","salutation","salvage","sanctimonious","sanction","sanctity","sanctuary","sane","sangfroid","sanguine","sap","sarcasm","sardonic","satiated","satiric","saucy","savagery","savant","scant","scanty","scarce","scathing","scatter","scepticism","scheme","schism","scintillate","scorn","scramble","scrap","scream","scruple","scrupulous","scrutinize","seamless","seasoned","secede","seclusion","sect","secular","sedative","sedentary","sedition","segregate","senility","sensible","sensory","sensual","sententious","sentient","sentinel","sequester","serendipity","serene","sermon","serpentine","servile","sever","sewer","shackle","shallow","sham","shanty","sheen","shibboleth","shirk","shiver","shortcoming","shrewd","shrivel","shun","sicken","similitude","singular","sinister","sink","site","skeptical","skew","skim","skimp","skirmish","skittish","skulk","slake","slander","slant","slavish","slender","slink","sloth","sloven","sluggish","sly","smash","smother","smudge","smug","sneak","sneer","snobbish","snotty","snub","snug","sober","solace","solicit","solicitous","solidarity","solvent","somber","somersault","somnolent","soothe","sophomoric","soporific","sordid","sovereign","spacious","spare","sparkle","sparse","spartan","spate","spawn","species","specimen","specious","spectacle","spectacular","specter","spectrum","speculate","spendthrift","spiteful","splendid","spoil","sporadic","spree","sprightly","sprinkle","sprout","spry","spurious","spurn","squalid","squalor","squander","squash","squeamish","stagger","stagnation","stain","stale","stalwart","stark","startle","static","statutory","staunch","steadfast","stealthy","steep","stench","sterile","sterilize","stern","stiff","stigmatize","sting","stingy","stink","stint","stipend","stipulate","stir","stoic","stolid","stout","strain","straits","stratagem","stratum","stray","strenuous","stretch","stricture","strident","strife","stringent","strive","stronghold","stubborn","stun","stupendious","stupendous","stupor","sturdy","stymie","suave","subdue","subjugate","sublime","submerge","submissive","subordinate","subservient","subside","subsidiary","subsidize","substantial","substantiate","substantive","substrate","subterfuge","subtle","subversive","successor","succinct","succor","succumb","suffice","suffocate","suffrage","suffuse","summit","sumptuous","sundry","superb","supercilious","superficial","superfluous","superior","supersede","supine","supplant","supple","supplement","supplication","suppress","supremacy","surfeit","surmise","surpass","surreal","surreptitious","surrogate","susceptible","suspicion","swallow","swamp","sway","swear","sweeping","swell","swerve","swift","swindler","swing","sybarite","sycophant","synergy","synopsis","syntax","synthesis","synthetic","systematic","systemic","tabloid","tacit","taciturn","tactical","taint","tame","tangential","tangible","tangled","tantamount","tantrum","tardy","taunt","tautological","tawdry","tedium","teem","teetotal","temerity","temperate","temporal","temporize","tempt","tenable","tenacious","tender","tenet","tenor","tentative","tenuous","tepid","termagant","terrific","terse","testy","thaw","theology","thesis","thorny","thorough","threshold","thrifty","thrive","throttle","thrust","thwart","tidy","timidity","timorous","tirade","titanic","titillate","titular","toady","toil","tomb","torment","torpid","torpor","torrent","tortuous","touchstone","touchy","toughen","tout","toxic","tractable","trait","traitor","trajectory","trample","transcend","transcontinental","transfix","transgress","transient","transpire","trauma","travesty","treacherous","treason","tremble","trenchant","trepidation","trespass","tribulation","trickster","trifling","trinket","trite","triumph","triumvirate","trivial","tropical","truce","trying","tryst","tumult","turbid","turbulent","turmoil","turpitude","tweak","tyranny","ubiquitous","ulterior","unanimous","unassuming","uncanny","unceasing","unconscionable","uncouth","unctuous","underlying","undermine","underpinning","underscore","understate","undertake","underwrite","unflinching","ungainly","ungraceful","uniform","unilateral","unison","unkempt","unleash","unprecedented","unravel","unrelenting","unremitting","unrepentant","unresolved","unwitting","unyielding","upbeat","upbraid","upbringing","upheaval","uphill","uphold","upright","uproar","urbane","usurp","usury","utilitarian","utmost","utopia","vacillate","vacuous","vagabond","vagary","vague","vail","valiant","valor","vandalism","vanity","vanquish","vapid","vehement","veil","venal","veneer","venerate","vengeance","venial","vent","venture","veracity","verbose","verdant","verge","verisimilitude","verity","vermin","vernacular","vertex","vested","vestige","veteran","vex","viable","vicarious","vicinity","vicissitude","vie","vigilant","vignette","vigorous","vile","vilify","vim","vindicate","vindictive","virile","virtuoso","virulent","visage","viscous","visionary","vitiate","vitriolic","vivacious","vivid","vocation","vociferous","vogue","volatile","volition","voluble","voluminous","voluptuous","voracious","vow","voyage","waft","waive","wake","wander","wanderlust","wane","wanton","warden","warp","warrant","wary","waver","wheedle","whining","wicked","willful","wily","wistful","wither","withhold","withstand","witty","wizened","woe","wooden","wrath","wretch","xenophobia","yearn","yell","yield","zealot","zealous","zeitgeist","zenith","zest"];



}//SocialMediaPostContents



class FacebookPagePostingHelper{
    use SocialMediaPostContents;

    private $wordWrittenOnBgPath = "images/jovocPage/word_written_on_bg.png"; // this path is essentially inside Storage::path("/public") folder

    public function getWordWrittenOnBg_Path(){
        /* In Laravel we are to run: php artisan storage:link
         * this command to make Storage::path("/public") work.
         * But for jovoc.com shared hosting I had to run: ln -s /home/jovocco1/public_html/jovoc/storage/app/public/images/jovocPage /home/jovocco1/public_html/storage/images/jovocPage
         *
         * The cause is probably public_html is the public directory in this server
         * */


        //dd( Storage::path("/public").'/'.$this->wordWrittenOnBgPath );
        return Storage::path("/public").'/'.$this->wordWrittenOnBgPath;
    }


    // curl -i -X GET "https://graph.facebook.com/v17.0/oauth/access_token?grant_type=fb_exchange_token&client_id=1472570683494634&client_secret=f952b3a6fbdf60c5b508527c2f0220e2&fb_exchange_token=token_here"


    public function postInJovoc($content, $additionalData = null){
        $pageId = env('PAGE_ID');
        $accessToken = env('PAGE_ACCESS_TOKEN');
        $content = urlencode($content);

        // Construct the cURL URL
        //$url = "https://graph.facebook.com/$pageId/feed?message=$content&access_token=$accessToken";

        if($additionalData !== null && isset($additionalData['word'])){
            //postType 'words'. we want to add image with API url
            $imageProcessor = new ImageProcessor();
            $imageProcessor->writeWordOnImage($additionalData['word']);


            /*
             * Image saved in storage/path/like/this . But to make publicly accessible this has been done. this way gives a path which works both in localhost and server
             * */
            $imagePath = $_SERVER['HTTP_HOST'].'/jovoc/storage/app/public/'.($this->wordWrittenOnBgPath);

            //tentative
            $imagePath = $_SERVER['HTTP_HOST'].'/jovoc/storage/app/public/images/jovocPage/words-3k-boss.png';


            /*
             * Must bear in mind that, API call won't work from localhost, since image saved in local server is not accessible through web.
             * */
            $url = "https://graph.facebook.com/$pageId/photos?url=$imagePath&caption=$content&access_token=$accessToken";
            //return $url;
        }
        //return ;

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        // Execute cURL session
        $response = curl_exec($ch);

        // Get the HTTP response code
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($ch);

        // Create an array with the response and response code
        $result = [
            "responseCode" => $responseCode,
            "response" => $response
        ];

        return $result;
    }//postInJovoc()



    public function wordDetails($word){
        //$word = 'accent'; //debugging purpose
        $data['word'] = $word;
        $wordId = null;

        $meaningsCollection = Meanings::where('word_id', function ($query) use ($word){
            $query->select('id')
                ->from('words')
                ->where('word', $word);})
            ->select('word_id', 'bangla_meaning')
            ->limit(4)
            ->get();
        //dd($meaningsCollection);


        $wordNo = null;
        $mainWords = $this->mainWords;
        if(in_array($word, $mainWords)){
            $wordNo = array_search($word, $mainWords) + 1;
            $data['wordNo'] = $wordNo;
        }


        $definitions = [];
        $Lib = new Library();
        $multipleBanglaMeaningExist = false;
        foreach ($meaningsCollection as $i=>$object){
            //dd($i);
            $definition = $object['bangla_meaning'];
            if($i == 0){
                $definition = $Lib->replaceFirstOccurrence($definition, "*", "");
                $wordId = $object['word_id'];
            }else if($i == 1){
                $definition = $Lib->replaceFirstOccurrence($definition, "#", "");
                if($definition){
                    //2nd definition exists
                    $multipleBanglaMeaningExist = true;
                }
            }else if($i >= 2){
                $definition = $Lib->replaceFirstOccurrence($definition, "#", "");
                $definition = $Lib->replaceFirstOccurrence($definition, "[cam]", "Cambridge Dictionary তে যেভাবে definition দেওয়া হয়েছে: ");
                $definition = $Lib->replaceFirstOccurrence($definition, "[ox]", "Oxford Dictionary তে যেভাবে definition দেওয়া হয়েছে: ");
                if($definition){
                    //parsing html
                    $dom = new \DOMDocument();
                    $dom->loadHTML(mb_convert_encoding($definition, 'HTML-ENTITIES', 'UTF-8'));
                    $definition = $dom->textContent;
                }else{
                    //empty string. so skip it.
                    continue;
                }
            }

            if($i <= 1){
                $definition = trim($definition);

                // Check if the string starts with a number and dot
                if (preg_match('/^[0-9]+\.\s*/', $definition)) {
                    //remove numbering 1. , 2. etc. if exists. because we will add numbering manually. If we dont remove starting number, some definition may look like: "1.1. definition here"
                    $definition = preg_replace('/^[0-9]+\.\s*/', '', $definition);
                    $definition = trim($definition);
                }
            }

            $definition = trim($definition);
            if($definition){
                array_push($definitions, $definition);
            }
        }
        if($multipleBanglaMeaningExist){
            $definitions[0] = '1. '.$definitions[0];
            $definitions[1] = '2. '.$definitions[1];
        }
        $data['definitions'] = $definitions;


        $partsOfSpeech = PartsOfSpeech::where('word_id', $wordId)->get(['parts_of_speech']);
        if(count($partsOfSpeech)>0){
            $data['parts_of_speech'] = @$partsOfSpeech[0]['parts_of_speech'] ?? null;
        }

        $sentences = $this->fetchSentences($wordId, 4);
        if(count($sentences) > 0){
            $data['sentences'] = $sentences;
        }

        return $data;

        //dd($data);
    }


    public function fetchSentences($wordId, $howMany){
        $sentences = [];
        $uses = WordUsages::where('word_id', $wordId)
            ->where('sentence', '!=', '>')
            ->where('sentence', 'NOT LIKE', '>%')
            ->limit($howMany)
            ->get(['sentence']);
        if(count($uses)>0){
            foreach ($uses as $object){
                $sentence = $object['sentence'];
                if($sentence){
                    array_push($sentences, $sentence);
                }
            }
        }
        return $sentences;
    }



    public function wordDetailsReadableContent($word){
        $wordDetails = $this->wordDetails($word);

        $wordNo = ''; //default value empty string
        if(array_key_exists('wordNo', $wordDetails)){
            $wordNo = 'Word No. ' . $wordDetails['wordNo'];
        }

        $readableContent = "---   ".$wordNo.' : '.$wordDetails['word']."   ---\n\n";

        foreach ($wordDetails['definitions'] as $i=>$definition){
            $readableContent = $readableContent. $definition."\n\n";
            if($i == 1){
                $readableContent = $readableContent."\n";
            }
        }

        if(! empty($wordDetails['parts_of_speech'])){
            $readableContent = $readableContent. "\nParts of speech: ".$wordDetails['parts_of_speech'];
        }

        $readableContent = $readableContent."\n\nsentence এ প্রয়োগ: \n\n";
        foreach ($wordDetails['sentences'] as $i=>$sentence){
            $readableContent = $readableContent.($i+1).'. '.$sentence."\n";
        }

        $readableContent = $readableContent."\n".$this->hashTagsForWordPost;

        return $readableContent;
    }



    /*
     * This function retrieves content of given type. Additionally saves which content has been used. And determines which content is to be used in next function call
     * */
    public function processContentSelection($postType){
        // to retain last used data, here we don't use database but use .txt file to store variable value. If specified file.txt in this path does not exist, .txt file will be created automatically and value will be written.
        $path = 'pagePost/jovoc/'.'lastArrIndex_'.$postType.'.txt'; /* this path is inside storage/app/ */
        $contents = $this->getContentsOfType($postType);

        if( sizeof($contents) == 0 ){
            //maybe something unexpected happened
            return 'NO CONTENT AVAILABLE';
        }

        $lastArrIndex = Storage::get($path);
        if(is_null($lastArrIndex) || !is_numeric($lastArrIndex)){
            //in case file path doesn't exist, value will be null. Probably first time. So array data never been used Then assign -1 to it.
            $lastArrIndex = -1;
        }

        $indexToUseThisTime = $lastArrIndex + 1;
        if($indexToUseThisTime >= sizeof($contents)){
            $indexToUseThisTime = 0;
        }
        $contentToUseThisTime = $contents[$indexToUseThisTime];

        //save the array index which has been used. In next function call this value will serve as the $lastArrIndex
        Storage::put($path, $indexToUseThisTime);

        return $contentToUseThisTime;
    }


}//FacebookPagePostingHelper




?>