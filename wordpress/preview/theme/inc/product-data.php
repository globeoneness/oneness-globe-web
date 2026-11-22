<?php
/**
 * ONENESS GLOBE — product literature data.
 *
 * Every technical value below was transcribed from the six original literature
 * PDFs (pack artwork), checked at 600 dpi where quantities or units were small.
 * Values are kept as printed. Items the artwork itself leaves unclear are listed
 * in 'review' and are shown only to logged-in site administrators.
 *
 * @package oneness-globe
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the six product-detail records, in display order, keyed by URL slug.
 *
 * @return array<string,array<string,mixed>>
 */
function og_get_products() {
	static $products = null;
	if ( null !== $products ) {
		return $products;
	}

	$products = array(

		/* ------------------------------------------------------------------ */
		'one-immune' => array(
			'slug'          => 'one-immune',
			'name'          => 'ONE IMMUNE',
			'category'      => 'Immune Enhancer',
			'tagline'       => 'Synbiotic immune enhancer',
			'pack'          => '100 gm',
			'mrp'           => 680,
			'photo'         => 'products/one-immune.webp',
			'photo_alt'     => 'ONE IMMUNE product pack, 100 gm',
			'literature'    => 'literature/one-immune.webp',
			'literature_w'  => 2600,
			'literature_h'  => 1757,
			'literature_alt' => 'ONE IMMUNE original brochure artwork (front and back panels)',
			'pdf'           => 'pdf/one-immune-literature.pdf',
			'intro'         => array(
				'One Immune is a next-generation synbiotic immune enhancer combining probiotics, prebiotics, enzymes, lysozyme, vitamins and antioxidants.',
			),
			'species'       => array( 'Poultry (Broilers & Layers)', 'Cattle (Dairy & Beef)' ),
			'composition'   => array(
				'type'  => 'table',
				'basis' => 'Each 100 gm contains:',
				'groups' => array(
					array(
						'title' => null,
						'rows'  => array(
							array( 'Lysozyme', '10g' ),
							array( 'Vitamin E', '10g' ),
							array( 'Vitamin C', '10g' ),
							array( 'Selenium', '400mg' ),
							array( 'Beta D glucans', '5g' ),
							array( 'Oligosaccharide', '5g' ),
							array( 'Biotin', '3g' ),
							array( 'Choline Chloride', '6g' ),
							array( 'Methionine', '3g' ),
							array( 'Bacillus Subtilis', '5×10° CFU/g' ),
							array( 'Lactobacillus', '1×109 CFU/g' ),
							array( 'Clostridium butyricum', '1×109 CFU/g' ),
							array( 'Lactobacillus Plantarum', '1×10° CFU/g' ),
							array( 'Bacillus Coagulans', '2×10° CFU/g' ),
							array( 'Saccharomyces boulardii', '1×10° CFU/g' ),
							array( 'Glucose Oxidase', '10g' ),
							array( 'β-mannan (MOS)', '8g' ),
							array( 'Zinc (chelated)', '1g' ),
							array( 'Vitamin A', '1,000,000 IU' ),
							array( 'Vitamin D', '200,000 IU' ),
							array( 'Enzyme Blend (xylanase + protease)', '1g' ),
							array( 'Yeast Culture (S. cerevisiae)', '2g' ),
							array( 'Excipients', 'q.s.' ),
						),
					),
				),
				'note'  => '',
			),
			'indications'   => array(
				array(
					'title' => 'For Poultry (Broilers & Layers)',
					'text'  => '',
					'items' => array(
						'Enhances innate and adaptive immunity through lysozyme, β-glucans, and probiotics.',
						'Supports gut health and microflora balance (Lactobacillus, Bacillus, MOS, oligosaccharides).',
						'Improves digestion and nutrient absorption via enzyme blend (xylanase + protease).',
						'Helps reduce FCR and improves growth performance.',
						'Protects against enteric disorders and supports recovery during bacterial & viral challenges (ND, IBD, E. coli).',
						'Reduces oxidative stress and improves overall flock vitality (Vitamin E, C, Selenium).',
						'Enhances egg production, shell quality, and fertility in layers.',
						'Supports liver function and metabolic efficiency.',
					),
				),
				array(
					'title' => 'For Cattle (Dairy & Beef)',
					'text'  => '',
					'items' => array(
						'Enhances rumen microbial balance and digestion efficiency.',
						'Improves feed utilization and energy metabolism (yeast culture + enzymes).',
						'Supports immune response and disease resistance.',
						'Helps reduce risk of metabolic disorders (fatty liver, ketosis).',
						'Improves milk yield and composition (fat %, SNF).',
						'Enhances fertility and reproductive performance.',
						'Supports recovery in mastitis and stress conditions.',
						'Improves overall productivity and body condition.',
					),
				),
			),
			'benefits'      => array(
				array(
					'title' => 'Front-of-pack claims',
					'text'  => '',
					'items' => array(
						'Supports gut health.',
						'Improves digestion and nutrient absorption.',
						'Promotes growth and productivity.',
					),
				),
			),
			'dosage'        => array(
				'intro' => '',
				'rows'  => array(
					array( 'Poultry', 'Use 1 gram per 2–3 liters of drinking water.' ),
					array( 'Cattle', 'Use 1 gram per 10–20 kg body weight, administered through drinking water or as directed by a registered veterinary Doctor.' ),
				),
				'notes' => array(),
			),
			'facts'         => array(
				array( 'label' => 'Storage', 'value' => 'Keep in Cool, Dry & Dark Place. Protect from Sun Light.' ),
				array( 'label' => 'Shelf life', 'value' => '3 years' ),
				array( 'label' => 'Withdrawal period', 'value' => 'Not stated in the supplied literature.' ),
				array( 'label' => 'Country of origin', 'value' => 'China' ),
				array( 'label' => 'Packing', 'value' => '100g' ),
			),
			'precautions'   => array(
				'For veterinary use only.',
			),
			'manufacturer'  => 'Vitboo',
			'importer'      => array( 'ONENESS GLOBE', '212/C, Bishow Bank Colony', 'Akborshah, Chattogram-4207, Bangladesh' ),
			'registration'  => 'DLS Registration No.: 1372',
			'badges'        => array( 'IMPORTED', 'ISO 9001:2015', 'GMP', '100% Satisfaction Guarantee' ),
			'review'        => array(
				'Quantities printed as "1×109 CFU/g" (Lactobacillus and Clostridium butyricum) and "5×10° CFU/g" / "1×10° CFU/g" (other probiotics) are shown exactly as printed. The exponent characters look inconsistent; please confirm the intended values.',
				'The brochure label reads "Self Life". It is shown here as "Shelf life".',
				'The source sentence has no comma between "prebiotics" and "enzymes"; a comma was added.',
				'No withdrawal period is printed on the supplied literature.',
			),
		),

		/* ------------------------------------------------------------------ */
		'grow-pro' => array(
			'slug'          => 'grow-pro',
			'name'          => 'Grow Pro',
			'category'      => 'Growth Promoter',
			'tagline'       => 'Multivitamin, Multimineral & Amino Acid Premix',
			'pack'          => '100 gm',
			'mrp'           => 530,
			'photo'         => 'products/grow-pro.webp',
			'photo_alt'     => 'Grow Pro product pack, 100 gm',
			'literature'    => 'literature/grow-pro.webp',
			'literature_w'  => 2600,
			'literature_h'  => 1758,
			'literature_alt' => 'Grow Pro original brochure artwork (front and back panels)',
			'pdf'           => 'pdf/grow-pro-literature.pdf',
			'intro'         => array(
				'Growth Promoter for poultry and all livestock species.',
				'Multivitamin, Multimineral & Amino Acid Premix.',
			),
			'species'       => array( 'Poultry', 'Dairy cattle', 'Beef cattle', 'Calves', 'Goat & sheep' ),
			'composition'   => array(
				'type'  => 'table',
				'basis' => 'Powder — each 100 g contains:',
				'groups' => array(
					array(
						'title' => 'Vitamins',
						'rows'  => array(
							array( 'Vitamin A', '1,350,000 IU' ),
							array( 'Vitamin D3', '415,000 IU' ),
							array( 'Vitamin E', '375 mg' ),
							array( 'Vitamin K3', '450 mg' ),
							array( 'Vitamin C', '500 mg' ),
							array( 'Vitamin B2 (Riboflavin)', '450 mg' ),
							array( 'Vitamin B6', '300 mg' ),
							array( 'Vitamin B12', '1,150 mcg' ),
							array( 'Niacin (Vitamin B3)', '900 mg' ),
							array( 'Folic Acid', '100 mg' ),
						),
					),
					array(
						'title' => 'Minerals',
						'rows'  => array(
							array( 'Calcium Lactate', '1,000 mg' ),
							array( 'Manganese Sulphate', '300 mg' ),
							array( 'Magnesium Sulphate', '250 mg' ),
							array( 'Copper Sulphate', '80 mg' ),
							array( 'Zinc Sulphate', '150 mg' ),
						),
					),
					array(
						'title' => 'Amino acids',
						'rows'  => array(
							array( 'L-Lysine', '1,600 mg' ),
							array( 'DL-Methionine', '1,200 mg' ),
							array( 'Threonine', '1,000 mg' ),
							array( 'Proline', '480 mg' ),
							array( 'Glutamic Acid', '800 mg' ),
						),
					),
					array(
						'title' => 'Other ingredients',
						'rows'  => array(
							array( 'Citric Acid', '1,000 mg' ),
							array( 'Glycerin', '200 mg' ),
							array( 'Carrier Base (Dextrose/Glucose)', 'q.s. to 100 g' ),
							array( 'Excipients', 'q.s.' ),
						),
					),
				),
				'note'  => '',
			),
			'indications'   => array(
				array(
					'title' => 'Indications',
					'text'  => '',
					'items' => array(
						'Supports optimal growth and weight gain in poultry and livestock through improved nutrient utilization and metabolic efficiency.',
						'Helps prevent and correct vitamin, mineral, and amino acid deficiencies under intensive farming conditions.',
						'Enhances feed conversion ratio (FCR) and promotes better production performance.',
						'Improves immune response and increases resistance to stress, infections, and diseases.',
						'Aids in recovery during illness, vaccination, transportation, and environmental stress (heat stress, seasonal changes).',
						'Promotes better egg production, hatchability, and shell quality in layers and breeders.',
						'Supports muscle development and tissue repair due to essential amino acid supplementation.',
						'Improves bone strength and skeletal development with balanced calcium and trace minerals.',
						'Enhance digestive efficiency and gut health, supporting better absorption of nutrients.',
						'Helps maintain overall vitality, productivity, and reproductive performance in cattle, poultry, and other livestock.',
					),
				),
			),
			'benefits'      => array(),
			'dosage'        => array(
				'intro' => '',
				'rows'  => array(
					array( 'Poultry', '100 g / 200–400 L drinking water;' ),
					array( 'Cattle & Buffalo', '5–10 g / 100 kg BW / day in drinking water;' ),
					array( 'Calves', '0.5–1 g / 10 kg BW / day in drinking water;' ),
					array( 'Goat & Sheep', '0.5–1 g / 10 kg BW / day in drinking water.' ),
				),
				'notes' => array(
					'During stress period dose may be doubled or Use as directed by a registered veterinarian.',
				),
			),
			'facts'         => array(
				array( 'label' => 'Storage', 'value' => 'Store in a cool and dry place, away from direct sunlight.' ),
				array( 'label' => 'Shelf life', 'value' => '3 years' ),
				array( 'label' => 'Withdrawal period', 'value' => '0 days' ),
				array( 'label' => 'Country of origin', 'value' => 'China' ),
				array( 'label' => 'Packing', 'value' => '100g' ),
			),
			'precautions'   => array(
				'For veterinary use only.',
				'Keep out of reach of children.',
			),
			'manufacturer'  => 'Vitboo',
			'importer'      => array( 'ONENESS GLOBE', '212/C, Bishow Bank Colony', 'Akborshah, Chattogram-4207, Bangladesh' ),
			'registration'  => 'DLS Registration No.: 1372',
			'badges'        => array( 'IMPORTED', 'GMP', 'ISO 9001' ),
			'review'        => array(
				'Dosage line "During stress period dose may be doubled or Use as directed by a registered veterinarian." is shown exactly as printed; the wording may need a full stop or an edit.',
			),
		),

		/* ------------------------------------------------------------------ */
		'essenguard-plus' => array(
			'slug'          => 'essenguard-plus',
			'name'          => 'EssenGuard™ Plus',
			'category'      => 'Advanced Gut Health & Antimicrobial Support',
			'tagline'       => 'Next-generation molecular-coated essential oil & organic acid blend',
			'pack'          => '200 gm',
			'mrp'           => 920,
			'photo'         => 'products/essenguard-plus.webp',
			'photo_alt'     => 'EssenGuard™ Plus product pack, 200 gm',
			'literature'    => 'literature/essenguard-plus.webp',
			'literature_w'  => 2600,
			'literature_h'  => 1759,
			'literature_alt' => 'EssenGuard™ Plus original brochure artwork (front and back panels)',
			'pdf'           => 'pdf/essenguard-plus-literature.pdf',
			'intro'         => array(
				'EssenGuard™ Plus is a next-generation, molecular-coated blend of essential oils and organic acids, specifically formulated to promote optimal gut health, control harmful bacteria, and enhance growth performance in livestock and poultry. This scientifically balanced, antibiotic-free solution supports digestion while maintaining animal health under veterinary guidance.',
			),
			'species'       => array( 'Poultry', 'Swine', 'Cattle & Buffalo', 'Sheep & Goat' ),
			'composition'   => array(
				'type'  => 'list',
				'basis' => 'Ingredients as printed on the literature',
				'items' => array( 'Thymol', 'Carvacrol', 'Cinnamaldehyde', 'Eugenol', 'Benzoic Acid', 'Citric Acid', 'Excipients q.s.' ),
				'note'  => 'The supplied literature lists these ingredients without individual quantities. Quantities are not stated on the original literature.',
			),
			'indications'   => array(),
			'benefits'      => array(
				array(
					'title' => 'Supports Gut Health & Digestion',
					'text'  => '',
					'items' => array(
						'Stimulates digestive enzyme activity and nutrient absorption.',
						'Maintains healthy gut microflora, reducing digestive disturbances like diarrhea or bloating.',
						'Strengthens overall immunity and resilience against infections.',
					),
				),
				array(
					'title' => 'Controls Harmful Bacteria',
					'text'  => '',
					'items' => array(
						'Natural antimicrobial compounds inhibit pathogenic bacteria such as E. coli, Salmonella, and Clostridium.',
						'Reduces mortality and improves overall herd/flock health.',
						'Safe long-term use with no contribution to antimicrobial resistance.',
					),
				),
				array(
					'title' => 'Improve Feed Efficiency (FCR)',
					'text'  => '',
					'items' => array(
						'Enhances feed utilization, allowing animals to gain more weight from the same feed.',
						'Reduces production costs per kg of meat or liter of milk.',
					),
				),
				array(
					'title' => 'Enhances Growth & Productivity',
					'text'  => '',
					'items' => array(
						'Supports optimal weight gain, egg production, and milk yield.',
						'Reduces energy loss to infections, allowing resources to focus on growth and performance.',
					),
				),
				array(
					'title' => 'Heat-Stable & Residue-Free',
					'text'  => '',
					'items' => array(
						'Maintains efficacy during feed processing such as pelleting or extrusion.',
						'Leaves no harmful residues in meat, milk, or eggs, ensuring food safety.',
					),
				),
				array(
					'title' => 'Antibiotic-Free Solution',
					'text'  => '',
					'items' => array(
						'Provides growth and health benefits without antibiotics.',
						'Helps maintain “clean-label” or antibiotic-free products for consumer markets.',
					),
				),
			),
			'dosage'        => array(
				'intro' => 'Feed use only; mix thoroughly with feed.',
				'rows'  => array(
					array( 'Poultry / Swine', '0.5–1 kg per metric ton of feed (0.5–1 g per kg of feed)' ),
					array( 'Cattle & Buffalo', '20–40 g/day for adults; 10–20 g/day for calves' ),
					array( 'Sheep & Goat', '5–10 g/day for adults; 3–5 g/day for young' ),
				),
				'notes' => array(
					'Or (Follow veterinarian guidance)',
				),
			),
			'facts'         => array(
				array( 'label' => 'Storage', 'value' => 'Keep in a cool and dry place, away from direct sunlight.' ),
				array( 'label' => 'Shelf life', 'value' => '3 years' ),
				array( 'label' => 'Withdrawal period', 'value' => 'None required. EssenGuard™ Plus is antibiotic-free and residue-free. Meat and milk can be safely harvested under standard veterinary guidance.' ),
				array( 'label' => 'Country of origin', 'value' => 'China' ),
				array( 'label' => 'Packing', 'value' => '200g' ),
			),
			'precautions'   => array(
				'For veterinary use only.',
				'Keep out of reach of children.',
				'Store in a cool and dry place, away from direct sunlight.',
			),
			'manufacturer'  => 'Henan Muxiang Import & Export Co. Ltd',
			'importer'      => array( 'ONENESS GLOBE', '212/C, Bishow Bank Colony', 'Akborshah, Chattogram-4207, Bangladesh' ),
			'registration'  => 'DLS Registration No.: 1372',
			'badges'        => array( 'IMPORTED', 'GMP', 'ISO 9001' ),
			'review'        => array(
				'The composition has no individual quantities on the literature. Please supply the amounts (with units) so they can be added exactly as the company approves.',
				'The dosage line "Cattle & Buffalo: 20–40 g/day ..." is shown as printed.',
			),
		),

		/* ------------------------------------------------------------------ */
		'livren-g' => array(
			'slug'          => 'livren-g',
			'name'          => 'LivRen-G',
			'category'      => 'Liver & Kidney Tonic',
			'tagline'       => 'Oral Solution — Advanced Hepato-Renal Support Formula',
			'pack'          => '500 ml',
			'mrp'           => 965,
			'photo'         => 'products/livren-g.webp',
			'photo_alt'     => 'LivRen-G product bottle, 500 ml',
			'literature'    => 'literature/livren-g.webp',
			'literature_w'  => 2600,
			'literature_h'  => 1758,
			'literature_alt' => 'LivRen-G original brochure artwork (front and back panels)',
			'pdf'           => 'pdf/livren-g-literature.pdf',
			'intro'         => array(
				'LivRen-G is a veterinary oral solution formulated to support healthy liver and kidney function in poultry and livestock. It helps protect the liver and kidneys from damage caused by toxins, drug residues, metabolic stress, feed contaminants, and disease-related weakness.',
				'LivRen-G is suitable for use during stress periods, recovery stages, and conditions where liver and kidney support is required.',
			),
			'species'       => array( 'Poultry', 'Livestock', 'Ducks' ),
			'composition'   => array(
				'type'  => 'table',
				'basis' => 'Each ml contains:',
				'groups' => array(
					array(
						'title' => null,
						'rows'  => array(
							array( 'Liver Cell Repair Factor', '200 mg/L' ),
							array( 'Taurine', '≥ 20000 mg/L' ),
							array( 'Glycyrrhetinic Acid', '≥ 40 mg/L' ),
							array( 'Vitamin B2', '≥ 50 mg/L' ),
							array( 'Excipients', 'q.s.' ),
						),
					),
				),
				'note'  => '',
			),
			'indications'   => array(
				array(
					'title' => 'Liver and kidney protection',
					'text'  => 'Supports liver and kidney function against damage caused by toxic substances such as Aspergillus flavus decomposition products, drug metabolites, and the body\'s own metabolic waste.',
					'items' => array(),
				),
				array(
					'title' => 'Liver disorder support',
					'text'  => 'Helps during symptoms related to liver degeneration, hepatomegaly, liver discoloration, fragile liver condition, and yellow-green liver caused by toxin exposure or medicine overdose.',
					'items' => array(),
				),
				array(
					'title' => 'Anti-toxin support',
					'text'  => 'Assists the body in reducing the harmful effects of toxins and supports natural detoxification functions.',
					'items' => array(),
				),
				array(
					'title' => 'Growth and performance support',
					'text'  => 'Use during 18–20 days and 26–28 days of age may support body resistance, improve feed conversion efficiency, and help reduce FCR.',
					'items' => array(),
				),
				array(
					'title' => 'Recovery support',
					'text'  => 'Helps improve body function and promotes recovery after disease, stress, medication, or toxin exposure.',
					'items' => array(),
				),
			),
			'benefits'      => array(
				array(
					'title' => 'Key benefits',
					'text'  => '',
					'items' => array(
						'Supports liver protection',
						'Helps kidney detoxification',
						'Improves FCR',
						'Supports toxin elimination',
						'Helps recover after disease',
						'Supports better body resistance',
						'Suitable for poultry and livestock',
						'Easy oral administration through drinking water',
					),
				),
			),
			'dosage'        => array(
				'intro' => '(Poultry, livestock, and ducks) For oral administration through drinking water.',
				'rows'  => array(
					array( 'General dose', '500 ml per 1500 L of drinking water for 3–5 days.' ),
					array( 'In serious conditions', '1 L per 1500 L of drinking water for 3–5 days.' ),
				),
				'notes' => array(
					'Or use as advised by a veterinarian or animal nutritionist.',
				),
			),
			'facts'         => array(
				array( 'label' => 'Storage', 'value' => 'Store cool, dry, away from direct sunlight.' ),
				array( 'label' => 'Shelf life', 'value' => '3 years' ),
				array( 'label' => 'Withdrawal period', 'value' => 'N/A' ),
				array( 'label' => 'Country of origin', 'value' => 'China' ),
				array( 'label' => 'Packing', 'value' => '500 ml' ),
			),
			'precautions'   => array(
				'Veterinary use only.',
				'Keep out of reach of children.',
			),
			'manufacturer'  => 'Henan Muxiang Import & Export Co., Ltd',
			'importer'      => array( 'ONENESS GLOBE', '212/C, Bishow Bank Colony', 'Akborshah, Chattogram-4207, Bangladesh' ),
			'registration'  => 'DLS Registration No.: 1372',
			'badges'        => array( 'GMP', 'ISO 9001' ),
			'review'        => array(),
		),

		/* ------------------------------------------------------------------ */
		'optiacid' => array(
			'slug'          => 'optiacid',
			'name'          => 'Optiacid',
			'category'      => 'Water Purifier & Acidifier',
			'tagline'       => 'For veterinary use only',
			'pack'          => '500 ml',
			'mrp'           => 715,
			'photo'         => 'products/optiacid.webp',
			'photo_alt'     => 'Optiacid product bottle, 500 ml',
			'literature'    => 'literature/optiacid.webp',
			'literature_w'  => 2600,
			'literature_h'  => 1758,
			'literature_alt' => 'Optiacid original brochure artwork (front and back panels)',
			'pdf'           => 'pdf/optiacid-literature.pdf',
			'intro'         => array(
				'OPTIACID is a veterinary acidifier and waterline hygiene solution specially formulated with organic acids and copper sulfate. It helps maintain clean drinking water, reduces harmful microorganisms in waterlines, supports better gut health, improves nutrient absorption, and promotes growth and production performance in poultry, livestock, and aquaculture.',
			),
			'species'       => array( 'Aquaculture', 'Poultry', 'Livestock' ),
			'composition'   => array(
				'type'  => 'table',
				'basis' => 'Each 500 ml contains:',
				'groups' => array(
					array(
						'title' => null,
						'rows'  => array(
							array( 'Formic Acid', '100 g' ),
							array( 'Acetic Acid', '90 g' ),
							array( 'Butyric Acid', '20 g' ),
							array( 'Citric Acid', '12.5 g' ),
							array( 'Copper Sulfate', '4 g' ),
							array( 'Solvent', '71 g' ),
							array( 'Water', 'q.s.' ),
							array( 'Excipients', 'q.s.' ),
						),
					),
				),
				'note'  => '',
			),
			'indications'   => array(),
			'benefits'      => array(
				array(
					'title' => 'Key benefits',
					'text'  => '',
					'items' => array(
						'Helps purify farm drinking water and waterlines (control pH)',
						'Eliminates more than 99.9% of microorganisms in waterlines',
						'Supports better digestion and nutrient absorption',
						'Promotes growth and improves production performance',
						'Helps maintain a cleaner farm environment',
						'Provides trace copper supplementation',
						'Suitable for poultry, livestock, and aquaculture',
					),
				),
			),
			'dosage'        => array(
				'intro' => '',
				'rows'  => array(
					array( 'Waterline disinfection', 'Use 500 ml per 100 L of water and soak for 24 hours. Flush properly before normal drinking water use.' ),
					array( 'Drinking water use', 'Use 0.2–0.3 L per 1000 L of Drinking Water or as directed by a veterinarian or nutritionist.' ),
				),
				'notes' => array(),
			),
			'facts'         => array(
				array( 'label' => 'Storage', 'value' => 'Keep out of reach of children. Store in a cool and dry place, away from direct sunlight.' ),
				array( 'label' => 'Shelf life', 'value' => '3 years' ),
				array( 'label' => 'Withdrawal period', 'value' => 'N/A' ),
				array( 'label' => 'Country of origin', 'value' => 'China' ),
				array( 'label' => 'Packing', 'value' => '500 ml' ),
			),
			'precautions'   => array(
				'For veterinary use only.',
				'Keep out of reach of children.',
			),
			'manufacturer'  => 'Henan Muxiang Import & Export Co., Ltd',
			'importer'      => array( 'ONENESS GLOBE', '212/C, Bishow Bank Colony', 'Akborshah, Chattogram-4207, Bangladesh' ),
			'registration'  => 'DLS Registration No.: 1372',
			'badges'        => array( 'GMP', 'ISO 9001' ),
			'review'        => array(
				'Composition amounts are printed in grams per 500 ml, including "Solvent 71 g". The unit is shown exactly as printed; please confirm the unit.',
			),
		),

		/* ------------------------------------------------------------------ */
		'mycoclean-plus' => array(
			'slug'          => 'mycoclean-plus',
			'name'          => 'Mycoclean Plus',
			'category'      => 'Bio Detox',
			'tagline'       => 'Powerful Mycotoxin Binder with Enzymes, Probiotics & Prebiotics',
			'pack'          => '200 gm',
			'mrp'           => 835,
			'photo'         => 'products/mycoclean-plus.webp',
			'photo_alt'     => 'Mycoclean Plus product pack, 200 gm',
			'literature'    => 'literature/mycoclean-plus.webp',
			'literature_w'  => 2600,
			'literature_h'  => 1762,
			'literature_alt' => 'Mycoclean Plus original brochure artwork (front and back panels)',
			'pdf'           => 'pdf/mycoclean-plus-literature.pdf',
			'intro'         => array(
				'MYCOCLEAN PLUS is a potent anti-mycotoxin solution formulated with advanced enzymes, probiotics, and prebiotics. It neutralizes harmful mycotoxins in feed and water, supports gut health, strengthens immunity, and enhances overall productivity. Its water-soluble formulation ensures easy administration across poultry, ducks, and cattle.',
			),
			'species'       => array( 'Poultry', 'Ducks', 'Cattle' ),
			'composition'   => array(
				'type'  => 'list',
				'basis' => 'Ingredients as printed on the literature',
				'items' => array(
					'Glucose Oxidase',
					'Aflatoxin B1 Degrading Enzyme',
					'Zearalenone Degrading Enzyme',
					'Deoxynivalenol (DON) Degrading Enzyme',
					'Lactobacillus spp.',
					'Mannan Oligosaccharides (MOS)',
					'Excipients q.s.',
				),
				'note'  => 'The supplied literature lists these ingredients without individual quantities. Quantities are not stated on the original literature.',
			),
			'indications'   => array(
				array(
					'title' => 'MYCOCLEAN PLUS is recommended for:',
					'text'  => '',
					'items' => array(
						'Prevention and reduction of mycotoxin-related health risks in poultry, ducks, and cattle.',
						'Support during poor feed intake, digestive stress or reduced immunity.',
						'Enhancing overall growth, productivity, and reproductive performance.',
						'Use during periods of suspected feed contamination or toxin exposure.',
					),
				),
			),
			'benefits'      => array(
				array(
					'title' => 'Powerful Mycotoxin Neutralization',
					'text'  => '',
					'items' => array(
						'Break down multiple toxins in feed and water.',
						'Reduces risk of liver, kidney, and gut damage.',
					),
				),
				array(
					'title' => 'Gut Health Support',
					'text'  => '',
					'items' => array(
						'Probiotics and prebiotics maintain healthy gut microflora.',
						'Improves digestion, nutrient absorption, and feed efficiency.',
						'Supports intestinal integrity and reduces gastrointestinal stress.',
					),
				),
				array(
					'title' => 'Immune System Enhancement',
					'text'  => '',
					'items' => array(
						'Strengthens natural defenses against infections.',
						'Counters toxin-induced immunosuppression.',
					),
				),
				array(
					'title' => 'Performance & Productivity',
					'text'  => '',
					'items' => array(
						'Promotes better growth, weight gain, and egg production.',
						'Protects reproductive health and improves hatchability.',
					),
				),
				array(
					'title' => 'Safe and Convenient',
					'text'  => '',
					'items' => array(
						'Antibiotic-free and eco-friendly, with no harmful residues.',
						'Water-soluble for easy administration.',
					),
				),
			),
			'dosage'        => array(
				'intro' => 'Drinking water only.',
				'rows'  => array(
					array( 'Poultry & Duck', '1 g per 2 liters of water' ),
					array( 'Cattle', '2–3 g per 10 liters of water' ),
				),
				'notes' => array(
					'Or (Follow veterinarian guidance)',
					'Use continuously during mycotoxin risk.',
					'Ensure medicated water is consumed within 24 hours.',
				),
			),
			'facts'         => array(
				array( 'label' => 'Storage', 'value' => 'Keep out of reach of children. Store in a cool and dry place, away from direct sunlight.' ),
				array( 'label' => 'Shelf life', 'value' => '3 years' ),
				array( 'label' => 'Withdrawal period', 'value' => 'N/A' ),
				array( 'label' => 'Country of origin', 'value' => 'China' ),
				array( 'label' => 'Packing', 'value' => '200g' ),
			),
			'precautions'   => array(
				'For veterinary use only.',
				'Keep out of reach of children.',
			),
			'manufacturer'  => 'Henan Muxiang Import & Export Co. Ltd',
			'importer'      => array( 'ONENESS GLOBE', '212/C, Bishow Bank Colony', 'Akborshah, Chattogram-4207, Bangladesh' ),
			'registration'  => 'DLS Registration No.: 1372',
			'badges'        => array( 'GMP', 'ISO 9001' ),
			'review'        => array(
				'PACK SIZE CONFLICT: the front panel prints "200G Net Weight" but the back panel prints "Packing: 500ml". The page shows 200 gm as instructed; please confirm which is correct before the back-panel wording is used.',
				'The Mycoclean Plus back panel reads "Packing: 500ml" while the front reads "200G". The product page follows the front-of-pack 200 gm.',
				'The benefits text prints "gastrointeistnal stress"; it is shown as "gastrointestinal stress". Please confirm.',
				'The composition has no individual quantities on the literature. Please supply the amounts (with units).',
			),
		),
	);

	return $products;
}
