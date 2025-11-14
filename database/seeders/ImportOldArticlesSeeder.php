<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Support\Str;

class ImportOldArticlesSeeder extends Seeder
{
    public function run()
    {
        $articles = [
            [
                'title' => 'Southampton Competition Report',
                'content' => '<h3>Southampton Competition Report: 21st November 2015: \'Forever & Always\' by Julia & Anwen (Birmingham)</h3>

<p>This weekend was again, as always an absolute honour to compete alongside such an amazing group of people. Even though we set off VERY early in the morning, it was so great to see everyone in such high spirits, with there being a lot of singing in the minibus & the car (apologies to those of you who were sleeping)!! A particular highlight of the journey however, was when we stopped at services with a WAITROSE (thanks Sam, you\'re the best!!) We arrived at the sports centre with plenty of time to spare so very wisely didn\'t go into isolation straight away and took the opportunity to remind ourselves of the pool and give fresher\'s a chance to take in the surroundings! We then became very jealous when we realised that in the room opposite isolation there were numerous bouncy castles, which we were not allowed to play on (a definite plan for Brum Comp isolation next year we feel!!)</p>

<p>Isolation went surprisingly fast this weekend, probably because we had an amazing quiz to do which kept us occupied for quite a while. It was entertaining to see how much competition it sparked amongst teams, with members going to great lengths to hide their answers from wandering eyes. Massive shout out to Richard for organising this – the Taylor Swift references were much appreciated!! Then, after captains briefing the teams started going out one by one and the competition began!!</p>

<p>The dry incident this weekend was a train crash, written by David Brown with the emphasis of treatment in confined spaces which really tested many teams!! We were handed train tickets at the beginning of the SERC, which was VERY exciting, and it was great how the SERC replicated a real life situation of travelling between carriages (with the team not being able to return with the first aid kit for 30 seconds). All teams excelled in different areas, and there were some fantastic performances on each casualty. The unconscious non breathing casualty was won by Brum D; head bleed won by Southampton A; hyperventilation won by Loughborough D; Broken wrist won by Oxbridge A; unconscious breathing won by Warwick A; asthmatic won by Loughborough B; the radio call won by Warwick A and the overall marks were won by Brum A. Congratulations to Warwick A for winning the dry SERC!!</p>

<p>The wet incident (written by Kyle O\'Callaghan) was set at a leisure centre and teams were briefed that they had arrived early to help with a gala set up – and of course a disaster had happened!! Kyle had sneakily hidden the first aid kit in the island as you entered the SERC and the majority of teams spotted this, which helped with treatments massively! The casualties included locked swimmers (one diabetic) which was won by Brum C; hyperventilation won by Brum A; a seizure (due to head injury), won by Brum B, a faint won by Brum A, a leg bleed won by Sheffield A, a panicking swimmer won by Sheffield B; body on the bottom was won by Warwick A; the phone call was won by Bristol B; and overall marks were won by Brum A. Congratulations to Brum A for winning the wet SERC!!</p>

<p>Both SERC\'S were very well written and challenging, but all teams excelled in different areas! Thank you to the SERC setters, judges, bodies and helpers for making the incidents run so smoothly!!</p>

<p>The speed events then came, and were the usual rope throw and swim and tow relay, with the league event being obs!! Transition between SERC and speeds was completed with great haste, and allowed for a quick and efficient turn around! The rope throw kicked off the start of the speeds; 3rd place was taken by Loughborough A, 2nd goes to Bristol A and the overall winners were Brum C, with an amazing time of 2 minutes and 4 seconds!! The obs relay was the first one of the BULSCA season and there were many speedy times!! 3rd place went to Loughborough B; 2nd place Loughborough A and the winners were Loughborough C with a time of 2 minutes and 6 seconds!! The final event of the day was the dreaded swim tow, shout out to everyone for finishing the race (always a good feeling!!) Congrats to the top 3 placing\'s; 3rd going to Bristol A, 2nd taken by Brum A and the winners of swim tow were Loughborough B with a time of 6.59 minutes!!</p>

<p>After a fantastic competition, the day was far from over! We all cartooned ourselves up and headed over to Southampton SU for some well deserved FOOD!! The SU looked absolutely amazing with a Christmas theme, thanks so much to Southampton for putting so much effort into the social. The Frozen cut out was much appreciated by Birmingham, being the focus of many group photos throughout the night; Birmingham was extremely proud to be awarded with best dressed, especially as Frozen was our chosen theme!! The photographer (SU Photographic Society Events Team) was also a lovely addition to the social and all the photos are available on FB (link on the BULSCA page!!). We enjoyed lots of dancing and even met SUSU the SU cat (I think she was slightly confused as to why loads of people were dressed as cartoon characters in her home)!!</p>

<p>Results started with the quiz outcome, of which Southampton won – congrats guys!! Results then swiftly (in true Taylor style) moved on to the main event… It\'s always a nail biting wait as teams are read backwards! A MASSIVE CONGRATULATIONS TO ALL TEAMS, RESULTS WERE INCREDIBLE! THE TOP THREE WERE: LOUGHBOROUGH C IN THIRD, WARWICK A IN SECOND, AND TOPPING THE LEADER BOARD, BIRMINGHAM A!!!
BULSCA A league is now sitting with Birmingham, and B league with Sheffield!! However all teams are very close at present- GAME ON GUYS!</p>

<p>To conclude this brilliant day, we would love to say the BIGGEST thank you to all of Southampton for putting on another outstanding competition; one to remember! We are now all preparing and looking forward to all of the remaining competitions, with London comp. drawing ever closer… see you all there!</p>

<p>Lifesaving love, Julia Whitworth (Birmingham Captain) and Anwen Rees (Secretary) xxx</p>',
                'published_at' => '2015-11-21',
                'tags' => ['comp-report', 'news'],
            ],
            [
                'title' => 'Committee Meeting 22/7/2013',
                'content' => '<p>The next BULSCA Committee meeting is on Monday 22nd July 2013.</p>
            
            <p>If you\'ve got anything you\'d like discussed, please send an email to Adam (Secretary – <a href="mailto:secretary@bulsca.co.uk">secretary@bulsca.co.uk</a>).</p>
            
            <p>Enjoy your summer!</p>
            
            <p><em>About Edward McCutcheon: BULSCA Treasurer 2013-14, RLSS UK Pool Lifeguard & Lifesaving Trainer Assessor</em></p>',
                'published_at' => '2013-07-22',
                'tags' => ['news'],
            ],
            [
                'title' => 'BULSCA Sport Leadership Conference',
                'content' => '<p>BULSCA was pleased to welcome a selection of invited, high profile, external speakers to the University of Birmingham on Sunday 23rd February 2014 for the BULSCA Sport Leadership Conference.</p>
            
            <p>Matt Quimby, National Line Throw Record holder, opened the event, followed by Steve Tedds from BULSCA Judges Panel. The RNLI sent Paul Barker to discuss \'Respect the Water\' with the group, before Adrian Mayhew, SLSGB National Lifesaving Commissioner introduced his organisation to us, and Elouise Greenwood, RLSS UK National Sport Development Manager, concluded the day with a talk on the new RLSS UK Sport Strategy.</p>
            
            <p>Our thanks to all the speakers for an extremely interesting event.</p>
            
            <p><em>About Edward McCutcheon: BULSCA Treasurer 2013-14, RLSS UK Pool Lifeguard & Lifesaving Trainer Assessor</em></p>',
                'published_at' => '2014-02-23',
                'tags' => ['news'],
            ],
            [
                'title' => '2014-15 Rulebook Published',
                'content' => '<p>The new rule book for the 2014 – 15 season has now been published and is available for download. There have been a number of changes including…</p>
            
            <ul>
            <li>The switchover to the new scoring system</li>
            <li>The timings for the release of competition results has been changed</li>
            <li>New Deputy Referee and Event Director roles added</li>
            <li>Rules to deal with the absence of RLSS Short Course Rules have been introduced</li>
            <li>References and small corrections have been made.</li>
            </ul>
            
            <p>There is also a new separate document that documents the new scoring system.</p>
            
            <p><strong>Documents:</strong></p>
            <ul>
            <li>Competition Manual</li>
            <li>List of Competition Manual Amendments</li>
            <li>Calculation of Results Document</li>
            </ul>
            
            <p>See you all at Warwick!</p>',
                'published_at' => '2014-09-01',
                'tags' => ['news'],
            ],
            [
                'title' => 'Freshers Comp Winners',
                'content' => '<p>Wow, what a day. Fantastic racing, great SERCs from Chris Harper and Oli Coleman. Ran smoothly by head Ref Alan and comp organisor Jamie.</p>
            
            <p>Well done to all:</p>
            
            <p><strong>Top freshers team was: Loughborough B</strong></p>
            
            <p><strong>Top team overall was: Birmingham A</strong></p>
            
            <p>Great start to the year</p>',
                'published_at' => '2014-10-26',
                'tags' => ['comp-report', 'league'],
            ],
            [
                'title' => 'Championships Date Confirmed',
                'content' => '<p>Student Championships has now been confirmed to be at Hengrove Pool, Bristol on the same weekend as intended at Bath 14/15th Mar 2015.</p>
            
            <p>Full entry details will be sent out soon. Sorry for the delay due to the change in Venue</p>',
                'published_at' => '2014-11-03',
                'tags' => ['student-championships', 'news'],
            ],
            [
                'title' => 'FIRST EVER BULSCA COMPETITION REPORT!',
                'content' => '<p>Firstly a very Happy New Year to you all!!</p>
            
            <p>With just over a week to go to Nottingham comp, we thought we put you all in a nostalgic mood with a hark back to the last competition of last year, London, so we present the first ever BULSCA comp report, written by our newest club Universities of Sheffield, and hope it fires up your competitive spirit and sets you looking forward to Notts.</p>
            
            <h3>LONDON comp – A brief reminiscence</h3>
            <p><em>by Shannon Potter – Universities of Sheffield</em></p>
            
            <p>I feel I must speak on behalf of most people when I say getting our Lifesaving groove on down in the old smoke was the most anticipated event of the academic year. Whether this is simply because I belong to the most northern BULSCA team in England, and the dream of being reunited with the heart of the south; where \'tea-cakes\' assume their proper sweet, fruity identities, was finally to become a reality, is possible. However either way, it was a Lifesaving- London sandwich, everyone\'s two favourite things, and it did not disappoint.</p>

            <p>Before the Lifesaving events had even begun, teams were already gallivanting around town like kids in a candy store looking for clues for the scavenger hunt. There were human pyramids, hen-dos, angry coppers, and a series of unconfirmed rumours that the London team had set this up to exhaust the rest of the teams and secure a win at our final competition.</p>

            <p>Of course, I joke. In fact, just like the City, the London team were fantastic hosts with everything ready and isolation starting pretty much on time (AND, I might add, the toilet breaks were organised wonderfully, a skill that is always appreciated, so thank you for that). Thus for the next couple of hours we filled the room with semi-conscious bodies, wasting souls and dreams of missed Facebook/twitter activity. As always there were the occasional outbursts of screaming from Birmingham, and Sheffield might have injured a few more people with their annoying attempts at catching ball (seriously though, who even invited them) but all in all it was a pretty classic, humdrum isolation.</p>

            <div class="text-center my-4">
                <img src="https://scontent-a-lhr.xx.fbcdn.net/hphotos-xaf1/v/t1.0-9/10702226_1541531686086600_4735113610141154718_n.jpg" alt="Universities of Sheffield team" class="img-fluid">
                <p class="text-muted"><em>Universities of Sheffield team</em></p>
            </div>
            
            <p>So on to the much more interesting events, the dry SERC began with all teams managing to get to the SERC location. The team were immediately put on edge, when they found themselves in a lottery, with one randomly selected team member being given a slightly different brief to the captain and the rest of the team. This incident involved a group of children on the beach whose game of tag has gone horribly wrong, some kids were poisoned by berries and throwing up everywhere, some had sand in their eyes and a couple had ran into each other at full speed and left bleeding on the floor. All in all these kids had a pretty poor understanding of how to play tag. Birmingham A scored highest in the dry, followed by Birmingham B and Loughborough A.</p>

            <p>Pretending the surprising turn of events in dry hadn\'t happened, competitors hastily moved on to the wet SERC hoping for some emotional reassurance. But London were feeling anything but reassuring. Within seconds they were cutting the head from Leviathan; with captains and team members split up for the beginning of the SERC. The idea being that captains had already been out at sea when the incident happened, and had sent the alarm for the others to join. So the captains, having been given their brief with the rest of the team, bravely ventured on alone for the first 20 seconds. From what I saw, most captains took this as an opportunity to call in casualties and work out where to send their members, with a few finding the radio or treating casualties. (And a couple of crazy rule breakers choosing not to get straight into the water, but teasing the sides for a few seconds too long because, society don\'t make the rules. They do what they want.) They were then joined by the rest of the team. The SERC involved a group of people out at sea, all members of the team had to be in the water, and once you had entered the water you couldn\'t get back out. There were no sides, so all casualties had to be treated in the water. Closest to the side was a hyperventilating casualty holding his unconscious, non-breathing child. Attempts at treatment varied dramatically; from the heroic CPR on the surfboard, to those that followed their coaches\' directives to the letter, breathing over the child\'s cheek for a good whole minute. The radio was located on a surfboard and there was a sugary drink floating in the water. Most teams coped well with the incident given that the set-up was unlike previous events that year. Warwick A came first for the wet SERC, with Birmingham C in second and Birmingham A third.</p>

            
            <div class="ratio ratio-16x9 my-4">
                <iframe src="https://www.youtube.com/embed/QDlkeXKz5I4" allowfullscreen></iframe>
            </div>
            
            <p>After an emotional shake-up, teams moved onto the speed events. As if we weren\'t psychologically drained already, London saw an opportunity to give us that pre-Christmas work out we\'d all not-been hoping for (apart from those, who had \'press-ups all day every day\' on the top of their list to Santa), with the rope throw, swim and tow and medley. All teams did very well, particularly Loughborough B taking first in the rope throw, Birmingham B winning the swim&tow and Loughborough A winning the Medley.</p>

            <p>The social saw the overall winners revealed with Birmingham A coming first, followed by Birmingham B in second and Loughborough A in third, so a huge congratulations to them, the very-deserving winners, and the rest of us the very-deserving, but happy and content, losers. All in all the London comp was a pretty delicious sandwich, with all the BULSCA classics and a couple of unexpected kicks to keep us on our toes for next year, best served with emotional guidance close by.</p>

            <p>Don\'t forget to keep us updated with how your training is going, twitter – @bulsca and in case you weren\'t aware we are also on instagram, @bulsca so keep us updated there.</p>

            <div class="text-center my-4">
                <img src="https://pbs.twimg.com/media/B4NIKsvCUAAhK5Y.jpg:large" alt="1st Birmingham A" class="img-fluid">
                <p class="text-muted"><em>1st Birmingham A (stand ins above)</em></p>
            </div>
            
            <p>Looking forward to seeing everyone there!</p>',
                'published_at' => '2015-01-30',
                'tags' => ['comp-report', 'league'],
            ],
            [
                'title' => 'If you go down to Sherwood today you\'re in for a big surprise …..',
                'content' => '<p><strong><em>(a Quidditch match gone badly wrong)</em></strong><br>by Bristol University</p>
            
            <p>It\'s the weekend of Nottingham competition, the day started at 7.30 when our driver had to cycle to the car hire place (Bristol Uni think that it is convenient to choose a car hire company 2 miles away from the central precinct, our club disagrees). At 8.30 we all piled into the car, a few stalls and a bit of gear crunching later and we were on our way.</p>
            
            <p>A three hour drive to Nottingham was broken up by a stop off at an RLSS employee\'s house to pick up 20 baby manikins, which were to turn into a source of much amusement later in the day. Cathy managed to beat Chris at a quiz game all by herself, the rest of the team gave moral support but absolutely not help whatsoever…. The conversations ranged from what order should we use in the races, through to what tactics to attempt in the SERCS and finally as to whether pregnancy is a conspiracy and babies are actually chosen from vending machines (Cathy, our medic, was rather sceptical, but Ben raised the point that in the olden days before special effects were particularly prevalent men were discouraged from attending the birth.)</p>
            
            <p>We failed in our first task at the competition, to find our captain some coffee which, despite stopping at a service station, meaning she survived an entire 12 hours on only one cup of coffee and the caffeine content of some delicious cupcakes made by Emily Castle\'s mother. Once we broke it to Cathy that her coffee couldn\'t be found we settled down for a long isolation (being third from last) with the standard "what time will we leave isolation?" bets being laid. Luckily we had, as per usual in isolation, the other teams to provide entertainment, what with misreading instructions and not realising travel first aid kits were required and turning team members into a mummies for a short time. The other entertainment was the crossword, the sort of puzzle a five year old can usually do, yet despite the 3 hours of isolation we didn\'t actually complete it, it didn\'t bode well for the rest of the competition. Our odd conversations continued through isolation, with the discussion of how lifesaving competitions will work in 2050 once tricorders have been invented and made first aid obsolete; plus how do you do CPR on a Venutian? Presumably you have to blow down their tentacles, any more ideas will be gratefully accepted and discussed at length in future isolations. Stéph discovered that cheddars exist, but refused to accept they were as good as mini cheddars, she just doesn\'t like how big they are.</p>
            
            <p>Finally we got the call to leave isolation, and for the first time, I managed to win the bet, plus Nottingham managed to keep to time. It was off to the dry we headed, with a few worried thoughts about maybe having to do it outside. Considering that over the years BULSCA SERCs have often contained subtle/not so subtle references to many different areas of popular culture (in the last couple of years there have been references to Dr Who, Cricket, X-Me, Pokemon, Star Wars and probably others I haven\'t even noticed) it wasn\'t a surprise that the dry SERC was used as another excuse to show just how geeky lifesavers can be by setting it at Hogwarts University Quidditch Pitch. The hectic incident was mostly going quite well, until it came to an utter breakdown in communication, Stéph had discovered a phone, Cathy didn\'t know about it and sent me out of the squash court where I was promptly told there wasn\'t a phone out there nor could I re-enter and let them know.</p>
            
            <p>The wet SERC was almost more successful, no one got locked out, the casualties were cleared from the water and both a phone and a radio were discovered. The radio was simulated as told explicitly to our captains, unfortunately the lack of coffee hit Cathy badly as she spent the whole SERC waiting for a response from the other end of the radio, she maintains being blonde and caffeine depleted is an acceptable excuse for this event.</p>
            
            <p>With just two teams after us it was very soon time for the races. The rope throw started us off quite well, with three of our team pulled in, next we had a lovely chat with ………………………………… censored …………………………….. which obviously left Cathy mentally scarred, but maybe it helped her swim faster in the medley. With the final swim and tow race done, it was time to play shower sardines before changing and contemplating food.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/02/first-photo-bristol-report.jpg" alt="The Nestene consciousness made an appearance" class="img-fluid" style="max-width: 300px;">
                <p class="text-muted"><em>The Nestene consciousness made an appearance…</em></p>
            </div>
            
            <p>On our way we stopped off to check on the manikins, unfortunately they had been misbehaving and had escaped from their bags. With the manikins all rounded up and placed back where they belonged we headed off to the bowls club for Dominos (who are rapidly becoming the official BULSCA food supplier), with an impressive £1 deal on spare pizzas going down very well around the clubs. Full stomachs and heavy legs left the competitors with just one desire, to find the final results; for the first time this year it was a B team to win, not only that but this is only the second year the club has existed. Many congratulations to Sheffield B, Birmingham A were 2nd and Birmingham B 3rd (we\'re assuming there is some correlation between the fact that Sheffield did the comp report for London and won in the next competition, it was the main reason we agreed to do this report).</p>
            
            <p>Unfortunately our car hire required us to be back in Bristol by 8 the next morning, and we voted as a club to leave after food rather than at 5 in the morning, we thought we\'d try to make an effort at dressing up like English football hooligans for our dinner though. Unfortunately a lack of suitable face paint and the mis-identifying of national flags meant we had one French flag between five of us to try and make a social outfit….Kieren did quite a good job of try, as can be seen in the photo!</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/02/second-photo-bristol-report.jpg" alt="Bristol team in French flag face paint" class="img-fluid">
            </div>
            
            <p>Our trip home was mostly uneventful with no conspiracy theories to mention at all. Rather importantly we did stop for coffee so at 10:30pm Cathy finally had a fully functioning brain, who said anything about medics being addicted?</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/02/third-photo-bristol-report.jpg" alt="Creative skills with crayons" class="img-fluid" style="max-width: 400px;">
                <p class="text-muted"><em>Sophie and Steph with their artwork - next stop the Turner Prize?</em></p>
            </div>
            
            <p>Our stop also provided an important opportunity for us to enrich our creative skills – aka use some crayons and pretend to be young children again. Sophie and Steph can be seen holding the products of our skills, next stop the Turner Prize?</p>
            
            <p>So after a busy day we hit our pillows, and rather gratefully our mattresses, just before midnight. Thank you for a great competition Nottingham and see you all in Birmingham (and a little less far North) next weekend.</p>',
                'published_at' => '2015-02-20',
                'tags' => ['comp-report', 'league'],
            ],
            [
                'title' => 'The tale of how BULSCA….',
                'content' => '<p><strong><span style="text-decoration: underline;">brought the Shipping Forecast, Blue Peter, Uptown Funk and a treacherous cave to Birmingham, and ended up shaking it all off</span></strong></p>
            <p><em>By Richard Evans – University of Southampton</em></p>
            
            <p>Well, here we go again. Last weekend, I enjoyed my second visit to a fellow lifesaving university of the month, and my new accidental tradition of writing up the experience is showing no signs of flagging.</p>
            
            <p>Nottingham took the hosting honours two weekends ago, and the torch was passed to Birmingham for this one. Birmingham and lifesaving go together like Manchester and University Challenge, if you get my drift. Some would probably argue that Birmingham and lifesaving go together more like Oxford and University Challenge, but there\'s not much difference, really. In other words, they\'re incredibly good, and they\'ve got very large, very dedicated teams. And we love them for it.</p>
            
            <p>"Birmingham\'s competition is always a good one," I was told by one of my Southampton teammates early last year. I needed no further persuasion to take part in Birmingham 2014. There was no doubt in my head, at any time over the following 365 days, that I would be back for Birmingham 2015. And, surely enough, I was back for Birmingham 2015, as one of eight Southampton lifesavers flying the flag for SULSC.</p>
            
            <p>I packed my bags on Friday evening, making sure that all the obvious essentials were ready to go, including my now infamous isolation snacks (more on them later), and turned in for the night just after 10pm, after listening to a Shipping Forecast on BBC iPlayer. There are very few more relaxing things in the world than the Shipping Forecast. There are very few less relaxing things in the world than being woken up at 3:35am by one\'s loud, inebriated housemates coming in through the front door. Something that is probably less relaxing than that is a nightmare about bad luck striking during a competition SERC or the car journey up the country to a competition – but I can\'t vouch for that myself. I blame Hannah for that one. She dreamt of slipping over in a muddy field the night before our home competition, and of oversleeping the night before driving up to Birmingham 2015. But, on the other side of the coin, she led a Southampton team to third place at our home competition, so maybe this latest dream of hers wasn\'t such a bad omen after all.</p>
            
            <p>After managing to return to sleep for a little while longer, I was officially woken up at 6:15am, and I sprang into action at once, grabbing my bags, packing some bread rolls and a massive Braeburn apple, and heading off to the Jubilee Sports Centre car park to rendezvous with everyone else by 7:45am. I forgot not to take Southampton A\'s torp and first aid kit with me and pack them into Hannah\'s car along with the rest of our bags. (Work that one out!) Poor Tom, Alex and Evie were promptly abandoned in the car park as Hannah and I relocated to the local petrol station to pick up our final two passengers, Lowri Burridge (former next-door neighbour of Paul Potts) and Sash Whale, before heading on up the country and ensuring that Hannah\'s "oversleeping and being late to the competition" nightmare wouldn\'t actually happen.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/11024581_854711737920618_519327797_o.jpg" alt="Southampton team member" class="img-fluid" style="max-width: 250px;">
            </div>
            
            <p>A few diversions on the roads leading into the city of Birmingham were the only hitches en route. We dared to speculate over whether this was a premonition of one of the SERCs.</p>
            
            <p>It certainly felt good to be back once we had finally found our way to the university sports centre. I ditched my bags for a few minutes and duly fulfilled my job of registering SULSC\'s presence, and promptly tied myself up in knots over the issue of paying for our white T-shirts for the evening. I meant to pay for one of our T-shirts, but I paid for 7 by mistake. The good news was that we definitely had the T-shirts. The bad news was that I had to bother everyone else in SULSC for £5 each.</p>
            
            <p>There was only one way we were all heading before too long, namely down the Spiral Staircase of Doom and straight into a massive dance studio (which immediately reminded me of the much smaller dance studio in which I took my black belt karate grading), which was to serve as the dreaded Isolation Venue! The good news was that this Isolation Venue was considerably larger and more comfortable than the Isolation Venue of 2014 – it was even equipped with roll mats. The bad news was that once we\'d set foot in the Isolation Venue, we ended up doing an increasingly convincing impression of Matt Smith\'s Eleventh Doctor after he\'d landed on the planet Trenzalore. (The Eleventh Doctor got stuck, albeit at his own behest, on the planet Trenzalore for 900 years. We weren\'t in the Isolation Venue for quite that long, but… there you have it.)</p>
            
            <p>The good news was that we relished every second of our time in our own version of Trenzalore, playing insanely silly card games, answering quiz questions (yes, I blame myself for that) and eating my infamous isolation snacks: good old mini breadsticks. They\'ve served us well at every competition I\'ve been to, and so I wasn\'t willing to break with tradition by not bringing them along this time!</p>
            
            <p>Talking of quiz questions, here\'s one I\'ve just made up: <em>while I was sitting in the social room in the evening at Birmingham 2014, one year ago this weekend, I checked the headlines on BBC News, and discovered that a national leader, under mounting pressure from a popular uprising in his country, had lost power and fled the country. Who was the leader, and which country was it?<sup>#</sup> (Answer at the bottom of the report)</em></p>
            
            <p>Captains\' Briefing signalled that the SERCs would be starting imminently, and that our time in our own version of Trenzalore was thus coming to a close. By this point, events were running some 45 minutes behind schedule, providing an ominous foretelling of the elaborateness of the SERCs. The extended Briefing churned out so many details that it became an ominous foretelling in itself. Blindfolds at the start of the wet SERC? No pool sides in existence during the wet SERC? <em>Additional things to take into the SERC as well as our specially prepared trousers and long-sleeved shirts?</em> We may as well have been preparing for a Bushtucker Trial – not that I\'m complaining! The anticipation was incredible, and it became even more so when I relayed all the information from the Briefing to my teammates. I\'ve never seen so many lifesavers listening so intently to anything.</p>
            
            <p>With Southampton\'s teams being 7<sup>th</sup> and 10<sup>th</sup> in the SERC running order, we ended up spending at least another half-hour in Trenzalore! The long wait didn\'t help our nerves, and neither did reading the dry SERC brief when the A-Team (Evie, Tom, SULSC Captain Iona and I, the SERC captain) was called into action. I have made a habit of saying "Bye!" to everyone in the room at training every time I go outside to eventually do a SERC, and I was perhaps too enthusiastic to be repeating that habit in Birmingham!</p>
            
            <p>The brief, in brief, mentioned caves and a convoluted layout. The SERC began, in brief, with Iona, Tom, Evie and I assuming the role of tourists on a caving tour, with hard hats and all, until the terrifying moment when there was a very audible cave-in ahead of us and we had to duck down to the ground for our own safety! I\'ve never starred in a disaster movie before. Perhaps this was my opportunity. If it weren\'t for the whistle that started the SERC, I might have believed I was in such a film.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/10997338_871157996239972_6143107203264843543_n.jpg" alt="Cave SERC scene" class="img-fluid">
            </div>
            
            <p>Alas, if it were a film, everything in the rescue would have gone perfectly, Iona and I wouldn\'t have got completely blockaded in the cave with three casualties (one of whom required CPR treatment) by a second cave-in, and I would have delivered a good performance as a captain. At least we were able to get the other casualties out of the deepest, darkest cave before it was too late. Full marks to everyone involved in the staging of this one, especially with the associated sound effects! No wonder we\'d spent so much time in Trenzalore leading up to this!</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/11021538_871713172851121_6319003015664239702_o.jpg" alt="Wet SERC preparation" class="img-fluid" style="max-width: 350px;">
            </div>
            
            <p>And then along came the wet SERC. With a Captains\' Briefing and the advance information from earlier in the week – ordering us to wear long-sleeved shirts and trousers into this one – this has a credible claim to being the most fearsome / most dreaded / most ambitious / most intricate SERC of all time! At least we didn\'t have to strip off in the cold car park this time. We are still shivering from the moment in Birmingham 2014 when we had to do just that.</p>
            
            <p>Blindfolds and lifejackets are scary things. The lead-in to the SERC only rammed that point home, as we had to don both <em>in addition to our clothes, and then walk in (admittedly under assistance from Dom of Nile Swimmers fame) with semi-wet clothes and no sight</em>! Dom\'s careful, authoritative instructions about our every move drove our anticipation and anxiety levels through the roof, as the blindfolds came off, our eyes remained trained on him (not the pool), and the dreaded whistle went, at which point we had to get into the pool "without hesitation". Presumably, repetition and deviation would have been unwelcome as well!</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/10626193_871713179517787_2526094097326434836_o.jpg" alt="Wet SERC in action" class="img-fluid">
            </div>
            
            <p>"Forties, Cromarty, Forth. Variable, 6 to gale 8, occasionally severe gale 9 or storm 10 later in Forties. Rain. Moderate, occasionally poor." Let\'s just say I\'ll never be able to listen to the Shipping Forecast in the same way again now I\'ve done this wet SERC. A re-enactment of the film The Perfect Storm in all but name, we were cast in the roles of shipwrecked seafarers, with our two fellow crewmembers severely injured or incapacitated, and the perishingly cold Pacific Ocean proving to be a decidedly uncomfortable resting place. There was even a boat in the scene to make it that bit more authentic. Not to mention roaring sea-based sound effects overlaying the scene, making it nigh-on impossible to hear what anyone was saying. I think it\'s fair to say that full marks go to the authors and stagehands behind this SERC as well, and negative marks go to me, partly because my tracksuit trousers slipped halfway off within the first two seconds.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/10856561_871713522851086_601361218881195242_o.jpg" alt="Teams watching wet SERC" class="img-fluid">
            </div>
            
            <p>Watching all the subsequent teams being escorted into the area while blindfolded, and then getting into the pool "without hesitation" and struggling to make themselves heard over the roaring sound effects, was morbidly enjoyable for all of us.</p>
            
            <p>So, eventually, there ended the SERCs, and there began the Rope Throwing! The bad news for Southampton A was that two of the twenty teams on the starting list for the competition had been unable to make it to Birmingham in the morning, so the reduced field needed to be reshuffled for the speeds heats – and we were booted from heat 2 to heat 1 with no warning, giving us hardly any time to get ready! The good news was that we were able to make the most of the shock, rescuing all four of us just inside the time available! That marked the first time that Iona and Tom had achieved this illustrious feat in a competition, and the second time for Evie and I. Good stuff. Southampton B rescued three casualties, in another very strong performance.</p>
            
            <p>Medley Relay was the next event to make its mark on proceedings, but as the four of us made our way to the marshalling zone in advance of our race, nobody bothered to remind us that the legendary Judges\' Rope Throw was taking place before that – the net result being that I looked, and felt, a bit of a wally for putting my fins on far too early. We were all determined not to feel that way once the relay got going, and I don\'t think we did in the end. Viewers may beg to differ. I pulled out what was possibly my personal best performance in leg 2 of the relay, so that was a relief.</p>
            
            <p>Which brought us on to Swim and Tow, and another of my infinitely many superstitions. This latest superstition of mine was that for me to take the last leg of the relay would bring good luck to the team, based on my personal experiences from four previous competitions! The good news was that it worked its magic and took us to first place in our heat. The bad news was that it also took us to a 15-second penalty. The good news was that everyone else in the heat also received 15-second penalties on the same grounds! The bad news… was that everyone else in the heat also received 15-second penalties on the same grounds. The good news was that according to Southampton B, watching from the sidelines, I was "properly sprinting" during my leg. The bad news was that I didn\'t feel like I was going particularly fast. The good news was that we took first place, which may or may not disprove my suspicion. The bad news was that my energy resources were completely depleted after the race, and we had to wait in the pool for at least 5 minutes before being let out! The good news… was that my energy resources were completely depleted after the race.</p>
            
            <p>Cue Birmingham\'s legendary Customary Additional Events, the Obs Relay and the Manikin Relay… or not. As it stood after Swim and Tow, things were two hours behind schedule, and nobody wanted to be late for our evening lasagne, so the Obs and Manikin Relays bit the dust, as we hit the changing rooms instead. Whether it would have been better spending those two hours doing Obs and Manikin Relays in the pool or playing card games on Trenzalore is up to you to decide.</p>
            
            <p>Either way, that lasagne was more than worth the wait, and it felt especially satisfying in light of our performances in the speeds. Something else that was more than worth the wait (not that any of us knew we were waiting for it) was the revelation of social organiser Julia\'s huge birthday cake and Happy Birthday song, which made for a wonderful moment of BULSCA camaraderie (not that BULSCA camaraderie is lacking at any other time, because it never is)! Pieces of cake were duly offered around, and I tried and failed to resist the offer.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/11045548_854711881253937_786040752_o.jpg" alt="Susu the cat mascot in progress" class="img-fluid" style="max-width: 250px;">
                <p class="text-muted"><em>Susu in progress</em></p>
            </div>
            
            <p>Southampton\'s amazingly charismatic cat (and University Challenge mascot) Susu joined the party after dinner, when Julia challenged each club to use the balloons, pipe cleaners, sellotape, scissors, card and felt provided to construct a "team mascot" within 30 minutes. There was never any question that we would be making a replica of Susu – but there was also, perhaps, no question that a number of other teams would use their resources to make imitations of a certain aspect of the anatomy of a human male. But those teams\' colourful efforts all went balls-up in the end, as Susu won the popular vote and saw Southampton rewarded with a box of Celebrations! Many thanks to our creative wizards Hannah and Sash for spearheading Susu\'s victory.</p>
            
            <p>So that was one result of the evening. The other big result of the evening was that Birmingham\'s competition had been won… by Birmingham. Birmingham\'s Old Boys, no less! Many congratulations to them. I just have a feeling that Champs 2015 will see a change in the identity of the Current Defending Lifesaving Champions.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/11018626_871158122906626_1541266746900646677_n.jpg" alt="Competition winners announcement" class="img-fluid">
            </div>
            
            <p>Finally, to top it all off, it was time for the lifesaving competition to give way to the only other thing in a lifesaving competition that I love as much as lifesaving – dancing. Lots of it. Beginning with an unofficial SULSC anthem, Bring It All Back (and I think it\'s official now that I\'ve said that!), and rolling on with a mix of nostalgic and contemporary classics, there was plenty of scope for dancing like nobody was watching, and it was fantastic. Uptown Funk was a definite highlight, along with Olly Murs\' inimitable Dance With Me Tonight, and a strangely-reassuringly-familiar 1990s track called All Star.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/10422512_871158519573253_6877446056698895996_n.jpg" alt="Social dancing" class="img-fluid">
            </div>
            
            <p>And let\'s not forget Baywatch. It\'s a shame Oli Coleman wasn\'t able to see me giving it my all – he\'ll know what I mean.</p>
            
            <p>And Shake It Off. Birmingham certainly knew how to keep this Swiftie happy. It was Blank Space at Nottingham, and I Knew You Were Trouble at Warwick – Loughborough, you\'ve got to come up with a different Taylor song at your competition next month! I will love you forever if you do, not that we didn\'t love you anyway!*</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/10361466_871158636239908_6281962305566393388_n.jpg" alt="Social celebration" class="img-fluid" style="max-width: 350px;">
            </div>
            
            <p>We finally left the social at a very chilly time, with our ears well and truly ringing. The weather and the ears ringing were the bad news. The good news was that the music had been loud enough that I couldn\'t hear myself singing at any time, and hopefully, neither could anyone else. I do love singing at these events, but I prefer it when I can do it without subjecting my friends to the dreadful sound of my singing voice, so thank you, Birmingham!</p>
            
            <p>In the morning, having packed up all our bumpf, including our (not quite dry) wet SERC clothes, we embarked back on the long journey down the country, via a service station (which used to be a Little Chef, which sadly is no more at this particular site!), and enjoyed the best (<em>i.e.</em> worst) of the Great British weather. And we heard Uptown Funk at least twice on the radio on the way, which didn\'t help my growing Post-Competition Depression very much.</p>
            
            <p>You know you\'ve had a magnificent time at a competition when the PCD kicks in on Sunday. I\'ve always had it after all of my competition experiences, and this was no exception, so thank you for everything, Birmingham. I won\'t say "we love you Birmingham", because I fear that\'s already been copyrighted by you! What I will say is that the countdown has well and truly begun for Champs in three weeks\' time, and I haven\'t been quite so excited about anything in my life since 1 February** last year. I cannot wait to meet you all there, for the biggest weekend in our lifesaving calendar. I have set myself a mission for Champs, but I\'m not going to reveal what it is, other than that it probably isn\'t what you think it is…</p>
            
            <p>*From lifesaving and University Challenge!<br>
            **What happened to me on 1 February last year? That\'s the kind of thing you either know or you don\'t!</p>
            
            <p><em><sup>#</sup>It was Viktor Yanukovych of Ukraine who lost power one year ago.</em></p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2015/03/11001937_871158386239933_1559565716606014890_n.jpg" alt="Thank You Birmingham" class="img-fluid">
                <p class="text-muted"><em>Thank You Birmingham</em></p>
            </div>',
                'published_at' => '2015-03-01',
                'tags' => ['comp-report', 'league'],
            ],
            [
                'title' => 'Thoughts from the chair',
                'content' => '<p><em>Our Chair Adam Martin reflects on a successful champs weekend.</em></p>
            
            <p>What a weekend. I have been a member of BULSCA for many years but never have I been to a competition that so perfectly encompasses the values of our organisation. Never have I been prouder to be a part of BULSCA.</p>
            
            <p>Before we began the odds were stacked against us, in the face of declining numbers attending the championships, and with our being forced to change venues there were serious discussions about whether hosting a championships was viable. Some will remember a meeting at Fresher\'s competition where we approved the use of some of BULSCA\'s reserve money to plug the hole in the budget. We warned the clubs that even with this money unless clubs maintained their entry levels the Championships would not be viable. You guys delivered on your end and we managed to maintain our pricing from last year.</p>
            
            <p>This weekend has been fantastic, the attitude of everyone involved was brilliant and all acted both in the spirit of the sport and with the values that are central to BULSCA. Judges, Competitors, Organisers and Helpers all conducted themselves in a manner that should make them proud.</p>
            
            <p>Saturday served to remind us that Lifesaving is more than just a sport, that the sport exists for a reason and when things went wrong the support from every person was exemplary. Whether you simply just got out of the way, or if you got involved in helping with the incident. Thank you. I imagine many of you like me will spend today looking over the photos and social media from the weekend and remember the weekend clubs drove each other to achieve their best that we might be better prepared to save lives and prevent drowning. As an organisation, we rose to the occasion.</p>',
                'published_at' => '2015-03-16',
                'tags' => ['comp-report', 'student-championships'],
            ],
            [
                'title' => 'So this is the end… Well until next year',
                'content' => '<p><em>By Cara Malorey-Vibert – University of Plymouth</em></p>
            
            <p><em>"The things I was allowed to experience, the people I was able to call friends, teammates, mentors, coaches and opponents, the travel, all of it, are far more than anything I ever thought possible in my lifetime."<br>
            – Curt Schilling</em></p>
            
            <p>So there we have it! 2014/15 BULSCA League is now over! And I think we can all agree what a way to end such an amazing year!</p>
            
            <p>The weekend started off early Saturday morning where all Club Chairmans/Captains and the BULSCA Committee came together for our annual AGM. Adam Martin (Chairman of 2014/15) came prepared with the paddle of rebuke in hand, ready to use when the subject got way out of subject …. And believe me … it is needed! …</p>
            
            <p>A lot was achieved in these short 4 hours! We reminisced the past year, looking back at what we all have achieved as individual clubs and BULSCA as a whole. And I\'m sure I speak for everyone here…. We\'ve done good! Without every members and helpers support we would not be like we are today! We are a unique, small and growing community that have made friends for life! And believe me … Once your a part of BULSCA … You never seem to leave! as most of you old timers know but that\'s what makes us, us! However with our new elected committee, fresh faced and enthusiastic as ever, I am sure we have a lot more excitement and change in store!</p>
            
            <p><em>"Set your goals high, and don\'t stop till you get there."<br>
            – Bo Jackson</em></p>
            
            <p>With all of our clubs support let\'s make these goals happen! Let\'s make 2015/16 even better! Lifesaving for Rio 2016? Let\'s put lifesaving on the map!!</p>
            
            <p>After a excitement filled 4hours our chairs and captains returned to their teams to get ready for the last event of the academic year. Isolation underway, smiles and game faces all round. Everyone meaning business, teams huddled together talking tactics and strategies as well as topping up their already high quality first aid knowledge. All in aid and desperation to get those last few league changing points that could mean the difference between league rankings.</p>
            
            <p><em>"Your only competition is yourself, work hard, train harder, work as a team and do your best. All you can do is improve, beat that pb/team goal and everyone\'s a winner."</em></p>
            
            <p>The teams were set off one by one doing both their Simulated Emergency Response Incidents. And any Game of Throne fans would have got increasingly excited once briefed for the dry incident, set in snowy woodland trail \'Stark Trail\' injured people everywhere, all teams calmly put their first aid and lifesaving knowledge into play, some cracking up some Game of Thrones quotes along the way. The teams then moved on to the wet incident, set as a beach environment this incident had various challenging casualties and elements to it, this creating small significant details that could gain many of those important points that every team are wanting to achieve.</p>
            
            <p>Competition spirit constantly increasing with every team completing their SERCS, discussion and comparisons going on in deep convocation as the SERCS come to an end. The speed events are then set up all on time and the heats of rope throw line up ready for action, some teams lucky, some not as much, but every team put in a high effort and skill. The manikin relay shortly followed, a convoy of orange BOBs speeding up and down the pool, Loughborough A dominating the event significantly. The Swim and Tow relay followed shortly after as we see some of our BULSCA members swimming for their university squads for the last time. As the event came to an end nothing else could be done to change the league of 2014/15.</p>
            
            <p>To round off the day we had a 4x50m freestyle friendly relay event, where all members swam for the last time this year in a BULSCA competition.</p>
            
            <p>High standards all round, all club captains and Chairmans proud of how far their clubs have come in the past year, a sigh of relief taken when realising that their work is done, and that the new generation of lifesavers are now here to help/or carry on the legacy of BULSCA and what we are all about.</p>
            
            <p>All members ready for the night ahead all congregated waiting to hear the results for the day. 1st- Birmingham A, 2nd- Warwick A and 3rd- Loughborough A. Thank you\'s\' were well and truly needed by this point to all of the judges and competition organisers for the whole year of competitions. We then all migrated to celebrate in the true Loughborough comp social way! Even Plymouth (the social addicts) approved! And believe me that is a tough task! Well done Loughborough!</p>
            
            <p>As club captain of the University of Plymouth Surf Lifesaving Society I would like to say a big thank you on behalf of all my committee and club for the hard work given from Adam/BULSCA committee, the panel of judges, helpers, sponsors and Charities that support us/BULSCA Clubs every step of the way. Without them none of this would happen, we very much appreciate the free time you give this society, as a club captain myself I know exactly the amount if not more effort you put in. And believe me, it\'s not as easy at it looks! So thank you!</p>
            
            <p>Good luck Sam O\'Connor and the new BULSCA Committee for 2015/16 and also the new Club committees! You have a tough year to top!</p>
            
            <p>Have a lovely summer! Your welcome to come down and train on the beaches with us next term see how far we travel to all your comps! Stay safe! Swim between the red and yellow flags! And no there isn\'t sharks and it isn\'t cold! So get in the water and start practicing for UPSLCs big BULSCA surprise for 2015/16! P.s. Make sure your free on the 26/27th of sept!</p>
            
            <p>Yyyeeeeewwwwwwww!</p>
            
            <p>Lifesaving Love from all of Plymouth!!</p>',
                'published_at' => '2015-03-29',
                'tags' => ['comp-report', 'league'],
            ],
            [
                'title' => 'Birmingham Bring Back BULSCA League in Brilliant Style',
                'content' => '<p>Forty-one teams from 11 universities across the UK put their skills to the test in the UK\'s biggest and most successful university lifesaving competition to date.</p>
            
            <p>Run by the British Universities Lifesaving Clubs\' Association (BULSCA), the first national competition of the academic year took place last weekend at University of Birmingham\'s Munrow Sports Centre.</p>
            
            <p>The competition puts competitors lifesaving skills to the test with two simulated emergency response in the water and on dry land. Competitors also demonstrated their fitness and lifesaving skills through a line (rope) throw race, a 50 metre swim tow timed race and a relay race made up of 50 metres front crawl, 50 metres swimming with fins on, 50 meters swimming with a torpedo buoy and 50 metres towing a casualty with a torpedo buoy.</p>
            
            <p>The competition is broken down into two categories – Freshers and Overall. The Freshers category are lifesavers in teams of four, who are competing for the first time in a university competition, whereas teams in the Overall category are made up of lifesavers in teams of four, who are regular participants in university competitions.</p>
            
            <p>University of Sheffield Team B were named the top team in the Freshers category, second place went to University of Birmingham Team B with Bristol University Team B coming in third.</p>
            
            <p>The Bristol University A team claimed competition gold, while second place went to a combined Oxford and Cambridge A team and current league title holders, The University of Birmingham A, took bronze.</p>
            
            <p>The competition is based on key principles of lifesaving and tests competitors\' CPR, in-water rescue and fitness skills. Assessed internally, the event allows universities from across the UK to demonstrate and compete using key lifesaving skills.</p>
            
            <p>The Royal Life Saving Society UK (RLSS UK), the Drowning Prevention Charity, is the governing body for Lifesaving Sport. RLSS UK\'s Chief Executive, Di Steer said: "This has been another fantastic first BULSCA competition of the year. It is great to see so many new university students from across the UK taking part in Lifesaving Sport.</p>
            
            <p>"Lifesaving Sport is not only a great way to make new friends when you first start at a university, it gives students essential water safety education but also skills that can save their own life and lives of others."</p>
            
            <p>BULSCA\'s Chair, Sam O\'Connor added: "The standard of competition this season has only reflected the growth of competitors at this year\'s competition- teams had to work really hard for every point this weekend- it\'s tremendously exciting to see so many athletes pushing so hard at the start of the season".</p>',
                'published_at' => '2015-11-18',
                'tags' => ['comp-report', 'league'],
            ],
            [
                'title' => 'Scott Chamberlin-Wibeke Resignation',
                'content' => '<p>It is with deepest regret that Scott has had to resign from his position as Data Manager due to other commitments. I, along with the rest of the committee, would like to thank Scott for the work he has done this season, and wish him all the best in his upcoming adventures.</p>
            
            <p>If you are interested in applying for Data manager, please email <a href="mailto:chair@bulsca.co.uk">chair@bulsca.co.uk</a></p>
            
            <p>Sam O\'Connor<br>
            BULSCA Chair<br>
            2015/16</p>',
                'published_at' => '2015-12-01',
                'tags' => ['news'],
            ],
            [
                'title' => 'Birmingham Fresher\'s Competition Report',
                'content' => '<p><em>by Emily Goodwin and Rob Forster - Loughborough University</em></p>
            
            <p>After a summer of hard work from the Loughborough Lifesaving Committee to prepare for what was to be our biggest intake of freshers in living memory, we were excited to get the first BULSCA competition of the year under our belt. The old system was thrown out the window, and in came the fresh new committee, ready to tackle the 2015/16 season like never before. With more pool time, longer sessions and a new attitude, Loughborough lifesaving club was ready to walk on water.</p>
            
            <p>As the first competition kicked off with a room full of new excited faces ready for the upcoming year, it gave us a chance to reflect on the previous year as a fresher. We remember the nerves, the excitement, the fear, and having absolutely no idea what was to come.</p>
            
            <p>Completely unprepared for what was to follow, the freshers were shipped out from the safety of isolation into oblivion, ready to encounter fake blood and plenty of panic. The dry SERC was testing from the off with all of our teams experiencing a situation that hadn\'t been practised. It was the first time many of our fresh recruits had come eye-to-eye with a casualty who was not giving in easily. But as far as a fresher scenario goes, that was hard. We admire the skill of Bristol and Sheffield who came out on top on that fine day.</p>
            
            <p>The wet SERC also did not disappoint. With complicated decisions to make regarding priorities, subtly placed rescue equipment, and reluctant casualties, it made for a good event.</p>
            
            <p>When it was time to get wet, our recruits were back in the space where they belong. The competition was stiff and rules strictly applied. It made for some fantastic competition filled with joy, success, frustration and tiredness after a long day! With a swift turn around between events there was no time to stop and reflect, but this echoes the admirable efficiency the coordinators achieved in circulating all of the competitors around the whole competition.</p>
            
            <p>All around this is looking to be a strong year for all clubs. Who knows who will take the league this year; it\'s anyone\'s game, and it will be a close one.</p>',
                'published_at' => '2015-12-04',
                'tags' => ['comp-report', 'league', 'news'],
            ],
            [
                'title' => 'Southampton Competition Report',
                'content' => '<p><em>Southampton Competition Report: 21st November 2015: \'Forever &amp; Always\' by Julia &amp; Anwen (Birmingham)</em></p>
            
            <p>This weekend was again, as always an absolute honour to compete alongside such an amazing group of people. Even though we set off VERY early in the morning, it was so great to see everyone in such high spirits, with there being a lot of singing in the minibus &amp; the car (apologies to those of you who were sleeping)!! A particular highlight of the journey however, was when we stopped at services with a WAITROSE (thanks Sam, you\'re the best!!) We arrived at the sports centre with plenty of time to spare so very wisely didn\'t go into isolation straight away and took the opportunity to remind ourselves of the pool and give fresher\'s a chance to take in the surroundings! We then became very jealous when we realised that in the room opposite isolation there were numerous bouncy castles, which we were not allowed to play on (a definite plan for Brum Comp isolation next year we feel!!)</p>
            
            <p>Isolation went surprisingly fast this weekend, probably because we had an amazing quiz to do which kept us occupied for quite a while. It was entertaining to see how much competition it sparked amongst teams, with members going to great lengths to hide their answers from wandering eyes. Massive shout out to Richard for organising this – the Taylor Swift references were much appreciated!! Then, after captains briefing the teams started going out one by one and the competition began!!</p>
            
            <p>The dry incident this weekend was a train crash, written by David Brown with the emphasis of treatment in confined spaces which really tested many teams!! We were handed train tickets at the beginning of the SERC, which was VERY exciting, and it was great how the SERC replicated a real life situation of travelling between carriages (with the team not being able to return with the first aid kit for 30 seconds). All teams excelled in different areas, and there were some fantastic performances on each casualty. The unconscious non breathing casualty was won by Brum D; head bleed won by Southampton A; hyperventilation won by Loughborough D; Broken wrist won by Oxbridge A; unconscious breathing won by Warwick A; asthmatic won by Loughborough B; the radio call won by Warwick A and the overall marks were won by Brum A. Congratulations to Warwick A for winning the dry SERC!!</p>
            
            <p>The wet incident (written by Kyle O\'Callaghan) was set at a leisure centre and teams were briefed that they had arrived early to help with a gala set up – and of course a disaster had happened!! Kyle had sneakily hidden the first aid kit in the island as you entered the SERC and the majority of teams spotted this, which helped with treatments massively! The casualties included locked swimmers (one diabetic) which was won by Brum C; hyperventilation won by Brum A; a seizure (due to head injury), won by Brum B, a faint won by Brum A, a leg bleed won by Sheffield A, a panicking swimmer won by Sheffield B; body on the bottom was won by Warwick A; the phone call was won by Bristol B; and overall marks were won by Brum A. Congratulations to Brum A for winning the wet SERC!!</p>
            
            <p>Both SERC\'S were very well written and challenging, but all teams excelled in different areas! Thank you to the SERC setters, judges, bodies and helpers for making the incidents run so smoothly!!</p>
            
            <p>The speed events then came, and were the usual rope throw and swim and tow relay, with the league event being obs!! Transition between SERC and speeds was completed with great haste, and allowed for a quick and efficient turn around! The rope throw kicked off the start of the speeds; 3rd place was taken by Loughborough A, 2nd goes to Bristol A and the overall winners were Brum C, with an amazing time of 2 minutes and 4 seconds!! The obs relay was the first one of the BULSCA season and there were many speedy times!! 3rd place went to Loughborough B; 2nd place Loughborough A and the winners were Loughborough C with a time of 2 minutes and 6 seconds!! The final event of the day was the dreaded swim tow, shout out to everyone for finishing the race (always a good feeling!!) Congrats to the top 3 placing\'s; 3rd going to Bristol A, 2nd taken by Brum A and the winners of swim tow were Loughborough B with a time of 6.59 minutes!!</p>
            
            <p>After a fantastic competition, the day was far from over! We all cartooned ourselves up and headed over to Southampton SU for some well deserved FOOD!! The SU looked absolutely amazing with a Christmas theme, thanks so much to Southampton for putting so much effort into the social. The Frozen cut out was much appreciated by Birmingham, being the focus of many group photos throughout the night; Birmingham was extremely proud to be awarded with best dressed, especially as Frozen was our chosen theme!! The photographer (SU Photographic Society Events Team) was also a lovely addition to the social and all the photos are available on FB (link on the BULSCA page!!). We enjoyed lots of dancing and even met SUSU the SU cat (I think she was slightly confused as to why loads of people were dressed as cartoon characters in her home)!!</p>
            
            <p>Results started with the quiz outcome, of which Southampton won – congrats guys!! Results then swiftly (in true Taylor style) moved on to the main event… It\'s always a nail biting wait as teams are read backwards! A MASSIVE CONGRATULATIONS TO ALL TEAMS, RESULTS WERE INCREDIBLE! THE TOP THREE WERE: LOUGHBOROUGH C IN THIRD, WARWICK A IN SECOND, AND TOPPING THE LEADER BOARD, BIRMINGHAM A!!!</p>
            
            <p>BULSCA A league is now sitting with Birmingham, and B league with Sheffield!! However all teams are very close at present- GAME ON GUYS!</p>
            
            <p>To conclude this brilliant day, we would love to say the BIGGEST thank you to all of Southampton for putting on another outstanding competition; one to remember! We are now all preparing and looking forward to all of the remaining competitions, with London comp. drawing ever closer… see you all there!</p>
            
            <p>Lifesaving love, Julia Whitworth (Birmingham Captain) and Anwen Rees (Secretary) xxx</p>',
                'published_at' => '2015-12-04',
                'tags' => ['comp-report', 'league', 'news'],
            ],
            [
                'title' => 'First Competition of 2016',
                'content' => '<p><strong>and Sheffield\'s first ever competition!</strong></p>
            
            <p><em>written by Sophie Priddis<br>
            University of Bristol</em></p>
            
            <p>We began our journey at 8.25am, leaving Bristol SU in a brand new shiny MPV. Spirits were high and the van was buzzing with anticipation for what we were assured was going to be the best competition of the year (but only because there\'s no Bristol comp this year). On the way I even learned that those annoying average speed checks on the motorway mean you actually have to drive at the same speed through the whole thing, not just slow back down when driving past the cameras. We somehow managed to make it to Sheffield in good time and without getting lost, stopping just past Birmingham to ensure that Cathy had a decent coffee to survive the day.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/01/bristol-driving.jpg" alt="Bristol team driving" class="img-fluid" style="max-width: 350px;">
            </div>
            
            <p>We claimed a nice sized area of the isolation room before the other teams began arriving took the remaining space. After four hours of eating, playing Set, playing Bananagrams, playing cheat, weeing, napping, complaining about being cold and complaining about being near the end of the SERC draw we were quickly lined up with the remaining teams to begin the long awaited competition. The dry SERC was interesting, to be honest I would have rather played Human Hungry Hippos instead of sorting out a game-gone-wrong. The wet SERC was also interesting. Training tip to take away from this report: pushing people with sun stroke back into the water isn\'t the best method of treating the problem – try an air-conditioned room instead.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/01/12773218_1029248490466941_981011014_o.jpg" alt="Isolation room" class="img-fluid">
            </div>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/01/bristol-rope-throw.jpg" alt="Bristol rope throw" class="img-fluid">
            </div>
            
            <p>Next of course was the rope throw relay, followed by medley relay (in which Bristol A managed to keep hold of the torpedo buoy this time). Team captains were called to an emergency meeting after the last heat of the medley relay, and we were delivered the amazingly delightful news that the distance of swim and tow was being halved due to time running short. It still felt like a long way to tow, but it could have been much worse had the SERCs taken less time than they did.</p>
            
            <p>By the time we got to the social venue, dressed in a last minute (literally sorted 8pm the night before) fancy dress of Noah\'s Ark, we were all more than ready for our chicken burgers (hence lack of poultry on Noah\'s Ark that evening). It\'s fair to say that there was no delay in the consumption of food to stop the hangryness setting in too deep, followed by a much needed pint. Results were given well done to Birmingham A who came first.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/01/12746261_1029807870411003_611796480_n.jpg" alt="Birmingham A winning the trophy" class="img-fluid" style="max-width: 350px;">
                <p class="text-muted"><em>Birmingham A winning the trophy</em></p>
            </div>
            
            <p>The obligatory Baywatch was played, although it did take several attempts to find the correct version. At the end of the social, the Bristol crew split into two. Myself and a few of my freshers decided to try out the club some of BULSCA were headed to that we were told was free entry (we Bristol students are poor so this was obviously an attractive selling point) and had cheap drinks. There was a queue when we got there, so we moved along and passed a few more bars/clubs before going into Beg, Borrow and Steal. Aptly named as it cost £12 for 4 shots, which is basically stealing from a student.</p>
            
            <p>Unsurprisingly, the van was much quieter on the way home, although it perked up slightly after a pit stop for coffee, water and Subway. Of course the tunes were bangin\' with the weekend trip ending with some Disney classics and, of course, \'I\'m Always Here\'.</p>
            
            <p>Excellent first competition from Sheffield, thanks to Helen and Shannon for organising a fun weekend, and thank you to our host, Holly, apparently your sofas were very comfortable to sleep on. Looking forward to seeing everyone again at the next competition.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/01/bristol-social.jpg" alt="Bristol social" class="img-fluid">
            </div>',
                'published_at' => '2016-02-22',
                'tags' => ['comp-report', 'news'],
            ],
            [
                'title' => 'Warwick Comp Report',
                'content' => '<p><em>written by Alex Collard</em></p>
            
            <p>When a comp forces one to get up at some unholy hour (6:10 am, to be precise) in order to simply get there on time, it must hold some redeeming features. The Warwick competition of February 26th can certainly be said to have provided enough of these to ultimately warrant me leaving my warm sheets and dodgy mattress whilst the sky was still dark, however.</p>
            
            <p>Upon our arrival at Warwick University (situated in Coventry, to trip up any unwary visitor), we were immediately ushered into a lecture theatre for isolation. This venue had the rather snazzy feature of a board that moves vertically along its axis at the push of a switch, naturally doing away with all my archaic notions that a board traditionally stays in the same place throughout the duration of the lesson. When I voiced my appreciation of this miraculous device, I was quickly informed that Nottingham also boasts a few of these wondrous creations. However, having never seen one with my own eyes, I readily disputed this claim. I cannot boast to have been into every lecture theatre and seminar classroom in the University, but I\'ve seen enough, damn it!</p>
            
            <p>But I digress.</p>
            
            <p>Our turn for the dry SERC came around a few hours later, by which point we were suitably fed and rested. Our B-Team, led by the fresher Jack \'The Tank\' Tapson, had left half an hour before, adding a certain tension to the demeanour of us remaining four. When we were led out into the corridor, each of us was presented with an envelope containing an invitation to a party for adults who can\'t handle the reality of their futile existences, and so apparently felt the urge to dress up and play party games for an afternoon. Of course, in reality I would never attend such a pathetic and meaningless event, but one must use one\'s imagination when it comes to SERCs, and therefore resolved to treat the injuries and ailments of these assorted morons.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/02/20160227_124553.jpg" alt="Party invitation envelope" class="img-fluid" style="max-width: 300px;">
            </div>
            
            <p>Entering the room, I went straight to a woman straddling a foul-smelling pile of vegetable soup. Realising this was representing some highly nutritious vomit, I treated her to the best of my ability, before moving on to console a young anaphylactic-sufferer and a hyperglycaemic man. Out of the corner of my eye, I saw Frazer dive headlong into a Jenga pile. Though my initial reaction was that the pressure had gotten to him and he\'d finally cracked, it quickly became apparent that there was a maniki…sorry, an \'unconscious, non-breathing casualty\' (with a severe limb deficiency) fiendishly concealed underneath. Meanwhile, Bryony was scouring the room for the First-Aid kit, at one point on her hands and knees under a table. When the whistle eventually blew, we had treated a vast majority of the casualties and phoned for an ambulance, though the location of the First-Aid kit remained a mystery until one of the judges took great pleasure in pointing it out on the back of the door we had entered through. Which, in my humble opinion, was cheating.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/02/12767201_10204305988009862_971900699_n.jpg" alt="Dry SERC in action" class="img-fluid">
            </div>
            
            <p>The Wet SERC, however, was the one that we were dreading. Written by Nottingham\'s own Mark McCaw…McQuor…McQuod…Mark M., we were already expecting a nefariously challenging event that would force us to think both logically and quickly. Yeah, like anyone can do that in a SERC. A particularly dim pincushion has more brainpower than me during those first few seconds. Nonetheless, we stepped out onto poolside, and immediately got to work. I went straight to a drunkard with a broken arm, ordering him to sit comfortably whilst I treated someone with a more serious problem. I confess that my bedside manner is somewhat lacking when I\'m stressed. I\'m sorry. Looking up, I saw a man about ten metres out who was struggling with something, so I shouted at him to come into the side. When he moved too slowly for my liking, I got in and towed him, my aforementioned lack of compassion for the inconvenienced coming into play once more. When we got in and I enquired as to the nature of his predicament, he informed me that he had asthma. Naturally, I asked where his inhaler was located, and after a few shaky breaths, he managed to utter \'Alex.\' I assured him, that yes, that was indeed my name, and it was really in his best interests to tell me where the inhaler was. At this point I was slightly concerned that he was trying to reach out to me in his final moments, and was preparing to inform me of his long-lost son, who had been working as a sheep-breeder in Mongolia for the past decade, following a domestic argument over a cheese grater, forcing me to go on a dramatic, cross-continental adventure with a wise-cracking sidekick, and inform the son that he was the sole benefactor of his late father\'s estate. After a few hours of soul-searching, he would come to forgive his father for slicing his cheese into strips rather than shavings all those years ago, and realise that he could not hide his true identity forever, thus allowing the ghost of asthma-man to rest in peace. My mission complete, I would return to my leafy suburban home, reuniting with my wife who would reveal that she had given birth to our first-born son in my absence, allowing us to name him after my wise-cracking sidekick (who was unfortunately devoured by rabid mountain goats as we passed through Tibet), thus beginning the cycle anew. ©Alex Collard, 2016.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/02/12804498_10204305988489874_1878174356_n.jpg" alt="Wet SERC scene" class="img-fluid">
            </div>
            
            <p>Actually, it turns out that was all me being an idiot. There was someone else called Alex in the SERC who had the inhaler. Which, let\'s be honest, is nowhere near as dramatic.</p>
            
            <p>Reunited with B-Team on the balcony overlooking the pool, we spent a couple of minutes laughing at me before comparing SERC performance. \'The Tank\' had done a fine job, keeping control even when feeling overwhelmed by the newfound pressures of captaining. They even found the bloody First-Aid kit in the dry SERC. From our vantage point, we could also watch the other teams attempt the SERC, with varying results. However, by the time the last team had finished, we were ready to show off our physical prowess in the water events.</p>
            
            <p>First up was the rope-throw. We don\'t talk about the rope-throw.</p>
            
            <p>With that debacle behind us, we pledged to redeem ourselves in the Obstacle Relay. Some of us had no experience of this event in an official competition, and so there was a degree of nervousness, particular amongst us Freshers. However, our performance was actually rather impressive, with B-Team placing well within their heat, and A-Team maintaining the lead throughout the race. To make matters better, in the time it had taken for us to complete the event, England had scored two Trys over Ireland, bringing home a presumably well-deserved victory. I like to think our achievements overshadowed that piddling little match, though.</p>
            
            <div class="text-center my-4">
                <img src="http://www.bulsca.uk/wp-content/uploads/2016/02/12809836_10204303387104841_1208630659_o.jpg" alt="Obstacle relay in action" class="img-fluid">
            </div>
            
            <p>And so, finally, we collected our Dominos and sat around a table to reflect. Could we have done better? Honestly, yes. Did we learn anything? Dear Lord, yes. Are we ready for Champs in a fortnight? Nearly. Because despite our various cock-ups, we\'d done decently. And we may never be the fastest, loudest, or most professional team out there, but I guarantee that we had the most laughs. And now you\'re expecting me to end on an upbeat, cheesy note of "And that\'s all that matters – taking part!" No. Of course not. It means that all the laughs are out of our systems now, and so we can focus solely on kicking some serious speedo-clad arse at Champs. You have been warned. The Green Shirts are coming.</p>',
                'published_at' => '2016-04-22',
                'tags' => ['comp-report', 'news'],
            ],
        ];


        foreach ($articles as $articleData) {
            // Check if article already exists by title
            $existingArticle = Article::where('title', $articleData['title'])
                ->whereDate('created_at', $articleData['published_at'])
                ->first();

            if ($existingArticle) {
                $this->command->warn("Skipped (already exists): {$articleData['title']}");
                continue;
            }

            $article = Article::create([
                'title' => $articleData['title'],
                'content' => $articleData['content'],
                'created_at' => $articleData['published_at'],
                'updated_at' => $articleData['published_at'],
            ]);

            // Attach tags
            $tagIds = Tag::whereIn('slug', $articleData['tags'])->pluck('id');
            $article->tags()->attach($tagIds);

            $this->command->info("Created: {$article->title}");
        }
    }
}