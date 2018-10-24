<?php
namespace Animates\Brands\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Animates\Brands\Model\BrandsFactory;
use Animates\Brands\Api\BrandsRepositoryInterface;

/**
 * Class ImportBrand
 * @package Animates\Brands\Console\Command
 */
class ImportBrand extends Command
{
    /**
     * @var BrandsFactory
     */
    protected $brandsFactory;

    /**
     * @var BrandsRepositoryInterface
     */
    protected $brandsRepository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\App\State
     */
    private $appState;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * ImportBrand constructor.
     *
     * @param BrandsFactory $brandsFactory
     * @param BrandsRepositoryInterface $brandsRepository
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        BrandsFactory $brandsFactory,
        BrandsRepositoryInterface $brandsRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->brandsFactory = $brandsFactory;
        $this->brandsRepository = $brandsRepository;
        $this->logger = $logger;

        parent::__construct();
    }

    /**
     * Initialization of the command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('animates:brandimport')
            ->setDescription('Brand Import');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '-1');

        $this->output = $output;

        try {
            $output->writeln(
                "<info>Import Start</info>"
            );

            $this->importBrands();

            $output->writeln(
                "<info>Import completed</info>"
            );
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                $output->writeln($e->getTraceAsString());
            }
            return;
        }
    }

    /**
     * Import Brands
     */
    public function importBrands()
    {
        $brands = [
            ['value'=> 1974, 'label' => 'Adaptil'],
            ['value'=> 1973, 'label' => 'Ammo'],
            ['value'=> 1957, 'label' => 'Baskerville'],
            ['value'=> 2416, 'label' => 'Black Hawk'],
            ['value'=> 1972, 'label' => 'Bravecto'],
            ['value'=> 1971, 'label' => 'Broadline'],
            ['value'=> 1970, 'label' => 'Comfortis'],
            ['value'=> 1969, 'label' => 'Epi Otic'],
            ['value'=> 1967, 'label' => 'Nexgard'],
            ['value'=> 1771, 'label' => 'Odorex'],
            ['value'=> 1688, 'label' => 'Pet Science'],
            ['value'=> 2000, 'label' => 'Petrageous'],
            ['value'=> 1947, 'label' => 'Petsafe'],
            ['value'=> 1689, 'label' => 'Petsport'],
            ['value'=> 1690, 'label' => 'Petware'],
            ['value'=> 2376, 'label' => 'PitPat'],
            ['value'=> 2381, 'label' => 'Plato'],
            ['value'=> 2399, 'label' => 'Playmate'],
            ['value'=> 2005, 'label' => 'Pond One'],
            ['value'=> 1898, 'label' => 'Poultry NZ'],
            ['value'=> 2026, 'label' => 'Precision'],
            ['value'=> 2263, 'label' => 'Prestige Pets'],
            ['value'=> 1695, 'label' => 'Profender'],
            ['value'=> 2387, 'label' => 'Prozym'],
            ['value'=> 1696, 'label' => 'Purina Beggin'],
            ['value'=> 1697, 'label' => 'Purina Beneful'],
            ['value'=> 1698, 'label' => 'Purina Chow'],
            ['value'=> 1699, 'label' => 'Purina Friskies'],
            ['value'=> 1966, 'label' => 'Sashas Blend'],
            ['value'=> 1626, 'label' => 'A-Door-Able'],
            ['value'=> 2071, 'label' => 'Action'],
            ['value'=> 1625, 'label' => 'Advantage'],
            ['value'=> 1624, 'label' => 'Advocate'],
            ['value'=> 2401, 'label' => 'Alien Flex'],
            ['value'=> 1623, 'label' => 'All for Paws'],
            ['value'=> 1916, 'label' => 'Andis'],
            ['value'=> 1622, 'label' => 'Animates'],
            ['value'=> 1996, 'label' => 'Arcadia'],
            ['value'=> 2284, 'label' => 'Aniwell'],
            ['value'=> 1989, 'label' => 'Anthel'],
            ['value'=> 1621, 'label' => 'API'],
            ['value'=> 1933, 'label' => 'Argus'],
            ['value'=> 1943, 'label' => 'Aquaclear'],
            ['value'=> 1944, 'label' => 'Aquananos'],
            ['value'=> 1619, 'label' => 'Aristopet'],
            ['value'=> 1620, 'label' => 'Aqua One'],
            ['value'=> 2379, 'label' => 'Aquastyle'],
            ['value'=> 2374, 'label' => 'Aquaworld'],
            ['value'=> 1914, 'label' => 'Avi One'],
            ['value'=> 1928, 'label' => 'Avitrol'],
            ['value'=> 2011, 'label' => 'Aqua Zonic'],
            ['value'=> 1990, 'label' => 'Aviverm'],
            ['value'=> 2057, 'label' => 'Bags on Board'],
            ['value'=> 2377, 'label' => 'Beco'],
            ['value'=> 1998, 'label' => 'Becothings'],
            ['value'=> 2418, 'label' => 'Benebone'],
            ['value'=> 1618, 'label' => 'Best Bird'],
            ['value'=> 2021, 'label' => 'Barkers Best'],
            ['value'=> 1617, 'label' => 'Bionic'],
            ['value'=> 1924, 'label' => 'Blackmores'],
            ['value'=> 2336, 'label' => 'Bio-Groom'],
            ['value'=> 1781, 'label' => 'BioPet'],
            ['value'=> 2354, 'label' => 'BiOrb'],
            ['value'=> 1946, 'label' => 'Blue Circle'],
            ['value'=> 1963, 'label' => 'Bond &amp; Co'],
            ['value'=> 1616, 'label' => 'Blue Planet'],
            ['value'=> 1941, 'label' => 'BomaZeal'],
            ['value'=> 1936, 'label' => 'Breeder Celect'],
            ['value'=> 2072, 'label' => 'Boomer'],
            ['value'=> 2384, 'label' => 'Bootique'],
            ['value'=> 1615, 'label' => 'Brooklands'],
            ['value'=> 1855, 'label' => 'Burgess'],
            ['value'=> 1614, 'label' => 'Butchers Superior Cuts'],
            ['value'=> 1823, 'label' => 'Canex'],
            ['value'=> 1613, 'label' => 'Capstar'],
            ['value'=> 2346, 'label' => 'Caitec'],
            ['value'=> 1612, 'label' => 'Carefresh'],
            ['value'=> 2349, 'label' => 'Categories'],
            ['value'=> 1940, 'label' => 'Cat Lax'],
            ['value'=> 1611, 'label' => 'Catit'],
            ['value'=> 1952, 'label' => 'Catwalk'],
            ['value'=> 1927, 'label' => 'ChapelWood'],
            ['value'=> 1610, 'label' => 'Chasers'],
            ['value'=> 1609, 'label' => 'Chewers'],
            ['value'=> 2067, 'label' => 'Classica'],
            ['value'=> 1934, 'label' => 'ComfyPet'],
            ['value'=> 2073, 'label' => 'Chuck It'],
            ['value'=> 1608, 'label' => 'Cloud 9'],
            ['value'=> 2029, 'label' => 'Clix'],
            ['value'=> 1607, 'label' => 'Comfy Cat'],
            ['value'=> 2022, 'label' => 'Coopet'],
            ['value'=> 1606, 'label' => 'Coprice'],
            ['value'=> 2350, 'label' => 'Crazy About Pets'],
            ['value'=> 1677, 'label' => 'Cuddlies'],
            ['value'=> 2001, 'label' => 'Cute Kitty'],
            ['value'=> 1676, 'label' => 'Dazzle'],
            ['value'=> 2046, 'label' => 'Dazzle Dog'],
            ['value'=> 1675, 'label' => 'Dine'],
            ['value'=> 2066, 'label' => 'Disney'],
            ['value'=> 2047, 'label' => 'Dermaleen'],
            ['value'=> 1674, 'label' => 'Dine Desire'],
            ['value'=> 2041, 'label' => 'Dogit'],
            ['value'=> 2058, 'label' => 'Dog Rocks'],
            ['value'=> 1673, 'label' => 'Doog'],
            ['value'=> 2348, 'label' => 'Drinkwell'],
            ['value'=> 1672, 'label' => 'Drontal'],
            ['value'=> 1780, 'label' => 'Dr Pottles'],
            ['value'=> 2042, 'label' => 'Durapet'],
            ['value'=> 1956, 'label' =>  'Eheim'],
            ['value'=> 2068, 'label' => 'Elements'],
            ['value'=> 1671, 'label' => 'Endogard'],
            ['value'=> 2074, 'label' => 'Entertaineeze'],
            ['value'=> 2009, 'label' => 'Elite'],
            ['value'=> 2415, 'label' => 'Ethical Agents'],
            ['value'=> 1670, 'label' => 'Eukanuba'],
            ['value'=> 1669, 'label' => 'Evance'],
            ['value'=> 1929, 'label' => 'Exceed'],
            ['value'=> 1991, 'label' => 'Exo Terra'],
            ['value'=> 2023, 'label' => 'Ezydog'],
            ['value'=> 1649, 'label' => 'Fancy Feast'],
            ['value'=> 1650, 'label' => 'Fancy Feast Elegant Medleys'],
            ['value'=> 1651, 'label' => 'Fancy Feast Gravy Lovers'],
            ['value'=> 1652, 'label' => 'Fancy Feast Mornings'],
            ['value'=> 1653, 'label' => 'Fancy Feast Royale Broths'],
            ['value'=> 1655, 'label' => 'Feline Natural'],
            ['value'=> 1968, 'label' => 'Feliway'],
            ['value'=> 1654, 'label' => 'Ferplast'],
            ['value'=> 1923, 'label' => 'Fidos'],
            ['value'=> 1935, 'label' => 'Flexi'],
            ['value'=> 2028, 'label' => 'Flippy'],
            ['value'=> 1656, 'label' => 'Flukers'],
            ['value'=> 1657, 'label' => 'Fluval'],
            ['value'=> 1992, 'label' => 'Frenzy'],
            ['value'=> 2398, 'label' => 'Fresh Smileezz'],
            ['value'=> 1658, 'label' => 'Fresheeze'],
            ['value'=> 1659, 'label' => 'Frolicat'],
            ['value'=> 1660, 'label' => 'Frontline'],
            ['value'=> 2380, 'label' => 'Fur &amp; Purr'],
            ['value'=> 1897, 'label' => 'Furminator'],
            ['value'=> 2059, 'label' => 'Get Off My Garden'],
            ['value'=> 2010, 'label' => 'Glo'],
            ['value'=> 1661, 'label' => 'Gnawlers'],
            ['value'=> 1662, 'label' => 'Go Cat'],
            ['value'=> 2409, 'label' => 'Go Dog'],
            ['value'=> 1962, 'label' => 'Good 2 Go'],
            ['value'=> 2075, 'label' => 'Gorrrrilla'],
            ['value'=> 1663, 'label' => 'Greenies'],
            ['value'=> 1776, 'label' => 'Grizzle'],
            ['value'=> 2045, 'label' => 'Guardian Gear'],
            ['value'=> 1664, 'label' => 'Hagen'],
            ['value'=> 2233, 'label' => 'Hamilton'],
            ['value'=> 2015, 'label' => 'Hailea'],
            ['value'=> 2378, 'label' => 'Harajuku'],
            ['value'=> 1665, 'label' => 'Hartz'],
            ['value'=> 2053, 'label' => 'Herbology'],
            ['value'=> 1666, 'label' => 'Hikari'],
            ['value'=> 1667, 'label' => 'Hill\'s Ideal Balance'],
            ['value'=> 1777, 'label' => 'Halti'],
            ['value'=> 1668, 'label' => 'Hills Science Diet'],
            ['value'=> 1627, 'label' => 'Holistic Select'],
            ['value'=> 1628, 'label' => 'Hot House Turtles'],
            ['value'=> 2060, 'label' => 'House Proud'],
            ['value'=> 2013, 'label' => 'HPM'],
            ['value'=> 1629, 'label' => 'Iams'],
            ['value'=> 1630, 'label' => 'Indorex'],
            ['value'=> 2358, 'label' => 'Isle of Dogs'],
            ['value'=> 2363, 'label' => 'Jackson Galaxy'],
            ['value'=> 2014, 'label' => 'Jager'],
            ['value'=> 2017, 'label' => 'JBF'],
            ['value'=> 1631, 'label' => 'JBL'],
            ['value'=> 2012, 'label' => 'Jebo'],
            ['value'=> 1632, 'label' => 'Jerhigh'],
            ['value'=> 2365, 'label' => 'Jungle Talk'],
            ['value'=> 2408, 'label' => 'Hear Doggy'],
            ['value'=> 1778, 'label' => 'House Proud'],
            ['value'=> 1633, 'label' => 'Jurassi-Diet'],
            ['value'=> 2410, 'label' => 'Kitty Fresh'],
            ['value'=> 1779, 'label' => 'Husher'],
            ['value'=> 1913, 'label' => 'Joy'],
            ['value'=> 2389, 'label' => 'Joy Love Hope'],
            ['value'=> 1634, 'label' => 'Just Play'],
            ['value'=> 1997, 'label' => 'Karlie'],
            ['value'=> 2003, 'label' => 'Juwel'],
            ['value'=> 1912, 'label' => 'JW'],
            ['value'=> 2254, 'label' => 'K&amp;H'],
            ['value'=> 1635, 'label' => 'K9 Natural'],
            ['value'=> 1636, 'label' => 'Kaytee'],
            ['value'=> 2253, 'label' => 'Kim Skins'],
            ['value'=> 1938, 'label' => 'Kiwi Cats'],
            ['value'=> 1959, 'label' => 'Kritters Crumble'],
            ['value'=> 1637, 'label' => 'Kong'],
            ['value'=> 2352, 'label' => 'Leaps &amp; Bounds'],
            ['value'=> 1899, 'label' => 'Kongs'],
            ['value'=> 2043, 'label' => 'Kufra'],
            ['value'=> 1638, 'label' => 'Laguna'],
            ['value'=> 2404, 'label' => 'Laxapet'],
            ['value'=> 1896, 'label' => 'Le Salon'],
            ['value'=> 2375, 'label' => 'LifeSpan'],
            ['value'=> 2396, 'label' => 'InSunCare'],
            ['value'=> 1937, 'label' => 'Lifestyle Pets'],
            ['value'=> 2061, 'label' => 'Little Stinker'],
            ['value'=> 1639, 'label' => 'Living World'],
            ['value'=> 1640, 'label' => 'LM'],
            ['value'=> 1641, 'label' => 'Love Em'],
            ['value'=> 1767, 'label' => 'KatAttack'],
            ['value'=> 1642, 'label' => 'M&amp;C'],
            ['value'=> 1951, 'label' => 'Kurgo'],
            ['value'=> 1643, 'label' => 'Magnet &amp; Steel'],
            ['value'=> 1768, 'label' => 'Kiwi Klassic'],
            ['value'=> 1644, 'label' => 'Mammoth'],
            ['value'=> 2002, 'label' => 'Mason Cash'],
            ['value'=> 2008, 'label' => 'Marina'],
            ['value'=> 1645, 'label' => 'Masterpet'],
            ['value'=> 1646, 'label' => 'Milbemax'],
            ['value'=> 1988, 'label' => 'MyBeau'],
            ['value'=> 1647, 'label' => 'My Dog'],
            ['value'=> 1648, 'label' => 'Nature Buddies'],
            ['value'=> 1911, 'label' => 'Natural Living'],
            ['value'=> 1678, 'label' => 'Natures Menu'],
            ['value'=> 1930, 'label' => 'Natures Miracle'],
            ['value'=> 2065, 'label' => 'Nickelodeon'],
            ['value'=> 1922, 'label' => 'Nootie'],
            ['value'=> 1679, 'label' => 'Nutrafin'],
            ['value'=> 2373, 'label' => 'Nutreats'],
            ['value'=> 1680, 'label' => 'Nutrience'],
            ['value'=> 1681, 'label' => 'Nutro'],
            ['value'=> 1682, 'label' => 'Nuts for Knots'],
            ['value'=> 1769, 'label' => 'MavLab'],
            ['value'=> 1683, 'label' => 'Nylabone'],
            ['value'=> 1684, 'label' => 'Old Mother Hubbard'],
            ['value'=> 2266, 'label' => 'Omega'],
            ['value'=> 2051, 'label' => 'Orapup'],
            ['value'=> 1685, 'label' => 'Organix'],
            ['value'=> 2007, 'label' => 'Panoramis'],
            ['value'=> 1953, 'label' => 'Petcorp'],
            ['value'=> 2360, 'label' => 'Outward Hound'],
            ['value'=> 1686, 'label' => 'Pedigree'],
            ['value'=> 2025, 'label' => 'Percell'],
            ['value'=> 1772, 'label' => 'Petkin'],
            ['value'=> 2407, 'label' => 'Pet Links'],
            ['value'=> 1955, 'label' => 'Pet Mate'],
            ['value'=> 1687, 'label' => 'Pet One'],
            ['value'=> 2412, 'label' => 'Pet Pal'],
            ['value'=> 2400, 'label' => 'PetBalance'],
            ['value'=> 1770, 'label' => 'Nilodour'],
            ['value'=> 2018, 'label' => 'Nirox'],
            ['value'=> 1910, 'label' => 'Penn Plax'],
            ['value'=> 1691, 'label' => 'Pork Shop'],
            ['value'=> 1692, 'label' => 'Prac-Tic'],
            ['value'=> 1693, 'label' => 'Pridelands'],
            ['value'=> 1694, 'label' => 'Primal'],
            ['value'=> 2040, 'label' => 'Prima Bolz'],
            ['value'=> 2392, 'label' => 'ProVida'],
            ['value'=> 1718, 'label' => 'Purina ProPlan'],
            ['value'=> 2395, 'label' => 'Purrs'],
            ['value'=> 2269, 'label' => 'Quiet Dog'],
            ['value'=> 1995, 'label' => 'Reptapet'],
            ['value'=> 1719, 'label' => 'Purritos'],
            ['value'=> 1915, 'label' => 'Red Dingo'],
            ['value'=> 2004, 'label' => 'Red Sea'],
            ['value'=> 1720, 'label' => 'Reptile One'],
            ['value'=> 1721, 'label' => 'Revolution'],
            ['value'=> 2027, 'label' => 'Road Runner'],
            ['value'=> 2359, 'label' => 'Rogz'],
            ['value'=> 1722, 'label' => 'Rolla Snak'],
            ['value'=> 2050, 'label' => 'Rose-Hip'],
            ['value'=> 1723, 'label' => 'Royal Canin'],
            ['value'=> 2371, 'label' => 'Royal Canin Vet Diet'],
            ['value'=> 1921, 'label' => 'Rudducks'],
            ['value'=> 2402, 'label' => 'Santi'],
            ['value'=> 1724, 'label' => 'Savic'],
            ['value'=> 1882, 'label' => 'Sargents'],
            ['value'=> 1725, 'label' => 'Schmackos'],
            ['value'=> 1773, 'label' => 'Proline'],
            ['value'=> 2063, 'label' => 'Scotch Brite'],
            ['value'=> 1726, 'label' => 'Seachem'],
            ['value'=> 2414, 'label' => 'Scruffs'],
            ['value'=> 2268, 'label' => 'Sera'],
            ['value'=> 1727, 'label' => 'Seresto'],
            ['value'=> 1920, 'label' => 'Shear Magic'],
            ['value'=> 2048, 'label' => 'Show Off'],
            ['value'=> 2411, 'label' => 'Simparica'],
            ['value'=> 2064, 'label' => 'Simple Green'],
            ['value'=> 2019, 'label' => 'Sleep Ezy'],
            ['value'=> 1950, 'label' => 'Slo-Bowl'],
            ['value'=> 1945, 'label' => 'Showmaster'],
            ['value'=> 2062, 'label' => 'Simple Solution'],
            ['value'=> 2383, 'label' => 'Smart N\' Tasty'],
            ['value'=> 1999, 'label' => 'Smarty Cat'],
            ['value'=> 1728, 'label' => 'Smite'],
            ['value'=> 2241, 'label' => 'Snoozzy'],
            ['value'=> 2024, 'label' => 'Solvit'],
            ['value'=> 1993, 'label' => 'Spot'],
            ['value'=> 2351, 'label' => 'Simply She'],
            ['value'=> 2055, 'label' => 'Skunk Shot'],
            ['value'=> 2044, 'label' => 'Smarty Dog'],
            ['value'=> 1932, 'label' => 'Snuggle Safe'],
            ['value'=> 2397, 'label' => 'SoPhresh'],
            ['value'=> 1954, 'label' => 'Sureflap'],
            ['value'=> 2267, 'label' => 'Tall Tails'],
            ['value'=> 1729, 'label' => 'Tetra'],
            ['value'=> 2056, 'label' => 'Sour Grapes'],
            ['value'=> 2388, 'label' => 'Star Wars'],
            ['value'=> 1961, 'label' => 'Swanndri'],
            ['value'=> 1982, 'label' => 'Tasty Bone'],
            ['value'=> 1730, 'label' => 'The Daily Bark'],
            ['value'=> 2069, 'label' => 'Teethers'],
            ['value'=> 2006, 'label' => 'The Water Cleanser'],
            ['value'=> 1942, 'label' => 'Thundershirt'],
            ['value'=> 1709, 'label' => 'Topflite'],
            ['value'=> 2393, 'label' => 'Torus'],
            ['value'=> 1965, 'label' => 'Triocil'],
            ['value'=> 2413, 'label' => 'Tramps'],
            ['value'=> 2049, 'label' => 'Triple Pet'],
            ['value'=> 1710, 'label' => 'Trixie'],
            ['value'=> 2386, 'label' => 'Trolls'],
            ['value'=> 1711, 'label' => 'Trouble &amp; Trix'],
            ['value'=> 1712, 'label' => 'Tuffy'],
            ['value'=> 1713, 'label' => 'Tui'],
            ['value'=> 2093, 'label' => 'Vetafarm'],
            ['value'=> 2054, 'label' => 'Virbac'],
            ['value'=> 1714, 'label' => 'VitaPet'],
            ['value'=> 1919, 'label' => 'Wahl'],
            ['value'=> 1994, 'label' => 'Ware'],
            ['value'=> 1715, 'label' => 'Waggin Wonders'],
            ['value'=> 1918, 'label' => 'Washbar'],
            ['value'=> 1716, 'label' => 'Wanpy'],
            ['value'=> 1717, 'label' => 'Wardley'],
            ['value'=> 1701, 'label' => 'Wellness'],
            ['value'=> 1774, 'label' => 'Silberhorn'],
            ['value'=> 1702, 'label' => 'Wellness Complete Health'],
            ['value'=> 1775, 'label' => 'Simple Green'],
            ['value'=> 1703, 'label' => 'Wellness Core'],
            ['value'=> 1762, 'label' => 'Skunk Shot'],
            ['value'=> 2385, 'label' => 'Watson &amp; Williams'],
            ['value'=> 1704, 'label' => 'Wellness Ninety-Five'],
            ['value'=> 2419, 'label' => 'Wellpet'],
            ['value'=> 1705, 'label' => 'Whimzees'],
            ['value'=> 1763, 'label' => 'Sour Grapes'],
            ['value'=> 1706, 'label' => 'Whiskas'],
            ['value'=> 2016, 'label' => 'Wizard'],
            ['value'=> 1707, 'label' => 'Wunder'],
            ['value'=> 2264, 'label' => 'You &amp; Me'],
            ['value'=> 1708, 'label' => 'Yours Droolly'],
            ['value'=> 1764, 'label' => 'Tigga'],
            ['value'=> 2403, 'label' => 'True Leaf Pet'],
            ['value'=> 1700, 'label' => 'ZiwiPeak'],
            ['value'=> 1765, 'label' => 'Triple Pet'],
            ['value'=> 1987, 'label' => 'Vet IQ'],
            ['value'=> 1766, 'label' => 'Whsitle'],
            ['value'=> 1925, 'label' => 'Wilpet'],
            ['value'=> 2052, 'label' => 'Wlpet'],
            ['value'=> 2406, 'label' => 'Zee.Cat'],
            ['value'=> 2405, 'label' => 'Zee.Dog'],
            ['value'=> 2417, 'label' => 'Zero'],
            ['value'=> 2070, 'label' => 'Zeua Zombie']
        ];

        foreach ($brands as $brand) {
            try {
                $data = [
                    'brand_id' => $brand['value'],
                    'brand_name' => $brand['label'],
                    'is_active' => 1
                ];
                $model = $this->brandsFactory->create();
                $model->setData($data);
                $this->brandsRepository->save($model);
            } catch (\Exception $e) {
                error_log($e->getMessage());
                $this->logger->critical($e->getMessage());
            }
        }
    }
}