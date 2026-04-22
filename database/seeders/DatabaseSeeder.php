<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@grukta.com',
            "type" => "admin"
        ]);

        User::factory()->create([
            'name' => 'Client User',
            'email' => 'client@grukta.com',
            "type" => "client"
        ]);

        // locations

        $now = Carbon::now();

        // ─────────────────────────────────────────────
        // PAÍSES
        // ─────────────────────────────────────────────
        $countries = [
            [
                'name'             => 'Angola',
                'location'         => 'Africa',
                'currency_symbol'  => 'Kz',
                'currency_code'    => 'AOA',
                'currency_position'=> 'before',
                'default_timezone' => 'Africa/Luanda',
                'capital'          => 'Luanda',
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'name'             => 'Brasil',
                'location'         => 'South America',
                'currency_symbol'  => 'R$',
                'currency_code'    => 'BRL',
                'currency_position'=> 'before',
                'default_timezone' => 'America/Sao_Paulo',
                'capital'          => 'Brasília',
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'name'             => 'Portugal',
                'location'         => 'Europe',
                'currency_symbol'  => '€',
                'currency_code'    => 'EUR',
                'currency_position'=> 'after',
                'default_timezone' => 'Europe/Lisbon',
                'capital'          => 'Lisboa',
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'name'             => 'Moçambique',
                'location'         => 'Africa',
                'currency_symbol'  => 'MT',
                'currency_code'    => 'MZN',
                'currency_position'=> 'before',
                'default_timezone' => 'Africa/Maputo',
                'capital'          => 'Maputo',
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ];

        DB::table('countries')->insertOrIgnore($countries);

        $angola     = DB::table('countries')->where('name', 'Angola')->value('id');
        $brasil     = DB::table('countries')->where('name', 'Brasil')->value('id');
        $portugal   = DB::table('countries')->where('name', 'Portugal')->value('id');
        $mocambique = DB::table('countries')->where('name', 'Moçambique')->value('id');

        // ─────────────────────────────────────────────
        // PROVÍNCIAS / ESTADOS / DISTRITOS
        // ─────────────────────────────────────────────

        /* ───── ANGOLA — 21 províncias (nova divisão administrativa) ───── */
        $angolaStates = [
            // ID  Name                     Capital
            ['Bengo',           'Africa', $angola],
            ['Benguela',        'Africa', $angola],
            ['Bié',             'Africa', $angola],
            ['Cabinda',         'Africa', $angola],
            ['Cuando Cubango',  'Africa', $angola],
            ['Cuanza Norte',    'Africa', $angola],
            ['Cuanza Sul',      'Africa', $angola],
            ['Cunene',          'Africa', $angola],
            ['Huambo',          'Africa', $angola],
            ['Huíla',           'Africa', $angola],
            ['Icolo e Bengo',   'Africa', $angola], // nova
            ['Luanda',          'Africa', $angola],
            ['Lunda Norte',     'Africa', $angola],
            ['Lunda Sul',       'Africa', $angola],
            ['Malanje',         'Africa', $angola],
            ['Moxico',          'Africa', $angola],
            ['Moxico Leste',    'Africa', $angola], // nova
            ['Namibe',          'Africa', $angola],
            ['Uíge',            'Africa', $angola],
            ['Cuando',          'Africa', $angola], // nova
            ['Zaire',           'Africa', $angola],
        ];

        foreach ($angolaStates as [$name, $location, $countryId]) {
            DB::table('states')->insertOrIgnore([
                'country_id' => $countryId,
                'name'       => $name,
                'location'   => $location,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /* ───── BRASIL — 26 estados + DF ───── */
        $brasilStates = [
            'Acre', 'Alagoas', 'Amapá', 'Amazonas', 'Bahia', 'Ceará',
            'Distrito Federal', 'Espírito Santo', 'Goiás', 'Maranhão',
            'Mato Grosso', 'Mato Grosso do Sul', 'Minas Gerais', 'Pará',
            'Paraíba', 'Paraná', 'Pernambuco', 'Piauí', 'Rio de Janeiro',
            'Rio Grande do Norte', 'Rio Grande do Sul', 'Rondônia', 'Roraima',
            'Santa Catarina', 'São Paulo', 'Sergipe', 'Tocantins',
        ];

        foreach ($brasilStates as $name) {
            DB::table('states')->insertOrIgnore([
                'country_id' => $brasil,
                'name'       => $name,
                'location'   => 'South America',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /* ───── PORTUGAL — 18 distritos ───── */
        $portugalStates = [
            'Aveiro', 'Beja', 'Braga', 'Bragança', 'Castelo Branco',
            'Coimbra', 'Évora', 'Faro', 'Guarda', 'Leiria', 'Lisboa',
            'Portalegre', 'Porto', 'Santarém', 'Setúbal', 'Viana do Castelo',
            'Vila Real', 'Viseu',
        ];

        foreach ($portugalStates as $name) {
            DB::table('states')->insertOrIgnore([
                'country_id' => $portugal,
                'name'       => $name,
                'location'   => 'Europe',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /* ───── MOÇAMBIQUE — 10 províncias + Maputo Cidade ───── */
        $mocambiqueStates = [
            'Cabo Delgado', 'Gaza', 'Inhambane', 'Manica', 'Maputo',
            'Cidade de Maputo', 'Nampula', 'Niassa', 'Sofala', 'Tete', 'Zambézia',
        ];

        foreach ($mocambiqueStates as $name) {
            DB::table('states')->insertOrIgnore([
                'country_id' => $mocambique,
                'name'       => $name,
                'location'   => 'Africa',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ─────────────────────────────────────────────
        // CIDADES
        // ─────────────────────────────────────────────

        /* Helper closure */
        $stateId = fn($countryId, $stateName) => DB::table('states')
            ->where('country_id', $countryId)
            ->where('name', $stateName)
            ->value('id');

        /* ─── Cidades de Angola ─── */
        $angolaCities = [
            // [province, [cidades]]
            ['Luanda',         ['Luanda', 'Cacuaco', 'Viana', 'Belas', 'Cazenga', 'Kilamba Kiaxi', 'Sambizanga', 'Maianga', 'Ingombota', 'Rangel']],
            ['Bengo',          ['Caxito', 'Dande', 'Ambriz', 'Bula Atumba', 'Dembos', 'Nambuangongo', 'Pango Aluquém']],
            ['Benguela',       ['Benguela', 'Lobito', 'Baía Farta', 'Balombo', 'Bocoio', 'Caimbambo', 'Chongoroi', 'Cubal', 'Ganda', 'Catumbela']],
            ['Bié',            ['Kuito', 'Andulo', 'Camacupa', 'Catabola', 'Chinguar', 'Chitembo', 'Cunhinga', 'Nharea']],
            ['Cabinda',        ['Cabinda', 'Belize', 'Buco-Zau', 'Cacongo']],
            ['Cuando Cubango', ['Menongue', 'Cuangar', 'Cuchi', 'Dirico', 'Mavinga', 'Nancova', 'Rivungo']],
            ['Cuanza Norte',   ['Ndalatando', 'Ambaca', 'Banga', 'Bolongongo', 'Cambambe', 'Cazengo', 'Golungo Alto', 'Gonguembo', 'Lucala', 'Quiculungo', 'Samba Caju']],
            ['Cuanza Sul',     ['Sumbe', 'Amboim', 'Ebo', 'Libolo', 'Mussende', 'Quibala', 'Quilenda', 'Seles', 'Conda']],
            ['Cunene',         ['Ondjiva', 'Cahama', 'Curoca', 'Cuanhama', 'Cuvelai', 'Namacunde']],
            ['Huambo',         ['Huambo', 'Bailundo', 'Caála', 'Catchiungo', 'Chicala Choloanga', 'Chinjenje', 'Ecunha', 'Londuimbali', 'Longonjo', 'Mungo', 'Tchicala-Tcholohanga', 'Ucuma']],
            ['Huíla',          ['Lubango', 'Cacula', 'Caconda', 'Caluquembe', 'Chiange', 'Chibia', 'Chicomba', 'Chipindo', 'Cuvango', 'Gambos', 'Humpata', 'Jamba', 'Kuvango', 'Matala', 'Quilengues']],
            ['Icolo e Bengo',  ['Calumbo', 'Catete', 'Calemba', 'Icolo e Bengo']],
            ['Lunda Norte',    ['Dundo', 'Alto Cuílo', 'Cambulo', 'Capenda-Camulemba', 'Caungula', 'Chitato', 'Cuango', 'Cuílo', 'Lubalo', 'Lucapa', 'Xá-Muteba']],
            ['Lunda Sul',      ['Saurimo', 'Cacolo', 'Dala', 'Muconda']],
            ['Malanje',        ['Malanje', 'Cacuso', 'Calandula', 'Cambundi-Catembo', 'Cangandala', 'Caombo', 'Cuaba Nzoji', 'Cunda-Dia-Baze', 'Luquembo', 'Marimba', 'Massango', 'Mucari', 'Quela', 'Quirima']],
            ['Moxico',         ['Luena', 'Alto Zambeze', 'Bundas', 'Cameia', 'Camanongue', 'Léua', 'Luacano', 'Luau', 'Luchazes', 'Moxico', 'Mumué']],
            ['Moxico Leste',   ['Cazombo', 'Lumbala N\'guimbo', 'Lumbala Caquengue']],
            ['Namibe',         ['Moçâmedes', 'Bibala', 'Camucuio', 'Curoca', 'Tômbwa', 'Virei']],
            ['Uíge',           ['Uíge', 'Alto Cauale', 'Ambuíla', 'Bembe', 'Buengas', 'Bungo', 'Damba', 'Macocola', 'Maquela do Zombo', 'Mucaba', 'Negage', 'Puri', 'Quimbele', 'Quitexe', 'Sanza Pombo', 'Songo', 'Zombo']],
            ['Cuando',         ['Cuito Cuanavale', 'Longa', 'Menongue Leste']],
            ['Zaire',          ['M\'banza Kongo', 'Cuimba', 'Nóqui', 'Nzeto', 'Soyo', 'Tomboco']],
        ];

        foreach ($angolaCities as [$stateName, $cities]) {
            $sid = $stateId($angola, $stateName);
            if (! $sid) continue;
            foreach ($cities as $city) {
                DB::table('cities')->insertOrIgnore([
                    'country_id' => $angola,
                    'state_id'   => $sid,
                    'name'       => $city,
                    'location'   => 'Africa',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        /* ─── Cidades do Brasil ─── */
        $brasilCities = [
            ['Acre',                 ['Rio Branco', 'Cruzeiro do Sul', 'Sena Madureira', 'Tarauacá']],
            ['Alagoas',              ['Maceió', 'Arapiraca', 'Palmeira dos Índios', 'União dos Palmares']],
            ['Amapá',                ['Macapá', 'Santana', 'Laranjal do Jari', 'Oiapoque']],
            ['Amazonas',             ['Manaus', 'Parintins', 'Itacoatiara', 'Manacapuru']],
            ['Bahia',                ['Salvador', 'Feira de Santana', 'Vitória da Conquista', 'Camaçari', 'Itabuna', 'Juazeiro', 'Ilhéus']],
            ['Ceará',                ['Fortaleza', 'Caucaia', 'Juazeiro do Norte', 'Maracanaú', 'Sobral', 'Crato']],
            ['Distrito Federal',     ['Brasília', 'Ceilândia', 'Taguatinga', 'Samambaia']],
            ['Espírito Santo',       ['Vitória', 'Serra', 'Vila Velha', 'Cariacica', 'Cachoeiro de Itapemirim']],
            ['Goiás',                ['Goiânia', 'Aparecida de Goiânia', 'Anápolis', 'Rio Verde', 'Luziânia']],
            ['Maranhão',             ['São Luís', 'Imperatriz', 'Caxias', 'Timon', 'Codó']],
            ['Mato Grosso',          ['Cuiabá', 'Várzea Grande', 'Rondonópolis', 'Sinop', 'Tangará da Serra']],
            ['Mato Grosso do Sul',   ['Campo Grande', 'Dourados', 'Três Lagoas', 'Corumbá', 'Ponta Porã']],
            ['Minas Gerais',         ['Belo Horizonte', 'Uberlândia', 'Contagem', 'Juiz de Fora', 'Betim', 'Montes Claros', 'Ribeirão das Neves', 'Uberaba']],
            ['Pará',                 ['Belém', 'Ananindeua', 'Santarém', 'Marabá', 'Castanhal', 'Parauapebas']],
            ['Paraíba',              ['João Pessoa', 'Campina Grande', 'Santa Rita', 'Patos', 'Bayeux']],
            ['Paraná',               ['Curitiba', 'Londrina', 'Maringá', 'Ponta Grossa', 'Cascavel', 'São José dos Pinhais', 'Foz do Iguaçu']],
            ['Pernambuco',           ['Recife', 'Caruaru', 'Olinda', 'Petrolina', 'Jaboatão dos Guararapes', 'Paulista']],
            ['Piauí',                ['Teresina', 'Parnaíba', 'Picos', 'Piripiri', 'Floriano']],
            ['Rio de Janeiro',       ['Rio de Janeiro', 'São Gonçalo', 'Duque de Caxias', 'Nova Iguaçu', 'Niterói', 'Belford Roxo', 'Petrópolis']],
            ['Rio Grande do Norte',  ['Natal', 'Mossoró', 'Parnamirim', 'São Gonçalo do Amarante', 'Macaíba']],
            ['Rio Grande do Sul',    ['Porto Alegre', 'Caxias do Sul', 'Canoas', 'Pelotas', 'Santa Maria', 'Gravataí', 'Novo Hamburgo']],
            ['Rondônia',             ['Porto Velho', 'Ji-Paraná', 'Ariquemes', 'Vilhena', 'Cacoal']],
            ['Roraima',              ['Boa Vista', 'Rorainópolis', 'Caracaraí']],
            ['Santa Catarina',       ['Florianópolis', 'Joinville', 'Blumenau', 'São José', 'Criciúma', 'Chapecó', 'Itajaí']],
            ['São Paulo',            ['São Paulo', 'Guarulhos', 'Campinas', 'São Bernardo do Campo', 'Santo André', 'Osasco', 'Ribeirão Preto', 'Sorocaba', 'Santos', 'São José dos Campos']],
            ['Sergipe',              ['Aracaju', 'Nossa Senhora do Socorro', 'Lagarto', 'Itabaiana', 'São Cristóvão']],
            ['Tocantins',            ['Palmas', 'Araguaína', 'Gurupi', 'Porto Nacional', 'Paraíso do Tocantins']],
        ];

        foreach ($brasilCities as [$stateName, $cities]) {
            $sid = $stateId($brasil, $stateName);
            if (! $sid) continue;
            foreach ($cities as $city) {
                DB::table('cities')->insertOrIgnore([
                    'country_id' => $brasil,
                    'state_id'   => $sid,
                    'name'       => $city,
                    'location'   => 'South America',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        /* ─── Cidades de Portugal ─── */
        $portugalCities = [
            ['Aveiro',          ['Aveiro', 'Águeda', 'Albergaria-a-Velha', 'Anadia', 'Estarreja', 'Ílhavo', 'Mealhada', 'Oliveira de Azeméis', 'Ovar', 'São João da Madeira', 'Vagos']],
            ['Beja',            ['Beja', 'Aljustrel', 'Almodôvar', 'Alvito', 'Castro Verde', 'Cuba', 'Ferreira do Alentejo', 'Mértola', 'Moura', 'Odemira', 'Ourique', 'Serpa', 'Vidigueira']],
            ['Braga',           ['Braga', 'Amares', 'Barcelos', 'Esposende', 'Fafe', 'Guimarães', 'Póvoa de Lanhoso', 'Terras de Bouro', 'Vieira do Minho', 'Vila Nova de Famalicão', 'Vila Verde', 'Vizela']],
            ['Bragança',        ['Bragança', 'Macedo de Cavaleiros', 'Miranda do Douro', 'Mirandela', 'Mogadouro', 'Vimioso', 'Vinhais']],
            ['Castelo Branco',  ['Castelo Branco', 'Covilhã', 'Fundão', 'Idanha-a-Nova', 'Oleiros', 'Penamacor', 'Proença-a-Nova', 'Sertã', 'Vila de Rei', 'Vila Velha de Ródão']],
            ['Coimbra',         ['Coimbra', 'Cantanhede', 'Condeixa-a-Nova', 'Figueira da Foz', 'Góis', 'Lousã', 'Mira', 'Miranda do Corvo', 'Montemor-o-Velho', 'Oliveira do Hospital', 'Pampilhosa da Serra', 'Penacova', 'Penela', 'Soure', 'Tábua', 'Vila Nova de Poiares']],
            ['Évora',           ['Évora', 'Alandroal', 'Arraiolos', 'Borba', 'Estremoz', 'Montemor-o-Novo', 'Mourão', 'Portel', 'Redondo', 'Reguengos de Monsaraz', 'Vendas Novas', 'Viana do Alentejo', 'Vila Viçosa']],
            ['Faro',            ['Faro', 'Albufeira', 'Alcoutim', 'Aljezur', 'Castro Marim', 'Lagos', 'Loulé', 'Monchique', 'Olhão', 'Portimão', 'São Brás de Alportel', 'Silves', 'Tavira', 'Vila do Bispo', 'Vila Real de Santo António']],
            ['Guarda',          ['Guarda', 'Aguiar da Beira', 'Almeida', 'Celorico da Beira', 'Figueira de Castelo Rodrigo', 'Fornos de Algodres', 'Gouveia', 'Manteigas', 'Mêda', 'Pinhel', 'Sabugal', 'Seia', 'Trancoso', 'Vila Nova de Foz Côa']],
            ['Leiria',          ['Leiria', 'Alcobaça', 'Alvaiázere', 'Ansião', 'Batalha', 'Bombarral', 'Caldas da Rainha', 'Castanheira de Pêra', 'Figueiró dos Vinhos', 'Marinha Grande', 'Nazaré', 'Óbidos', 'Pedrógão Grande', 'Peniche', 'Pombal', 'Porto de Mós']],
            ['Lisboa',          ['Lisboa', 'Amadora', 'Azambuja', 'Cadaval', 'Cascais', 'Loures', 'Lourinhã', 'Mafra', 'Odivelas', 'Oeiras', 'Sintra', 'Sobral de Monte Agraço', 'Torres Vedras', 'Vila Franca de Xira']],
            ['Portalegre',      ['Portalegre', 'Alter do Chão', 'Arronches', 'Avis', 'Campo Maior', 'Castelo de Vide', 'Crato', 'Elvas', 'Fronteira', 'Gavião', 'Marvão', 'Monforte', 'Nisa', 'Ponte de Sor', 'Sousel']],
            ['Porto',           ['Porto', 'Amarante', 'Baião', 'Felgueiras', 'Gondomar', 'Lousada', 'Maia', 'Marco de Canaveses', 'Matosinhos', 'Paços de Ferreira', 'Paredes', 'Penafiel', 'Póvoa de Varzim', 'Santo Tirso', 'Trofa', 'Valongo', 'Vila do Conde', 'Vila Nova de Gaia']],
            ['Santarém',        ['Santarém', 'Abrantes', 'Alcanena', 'Almeirim', 'Alpiarça', 'Benavente', 'Cartaxo', 'Chamusca', 'Constância', 'Coruche', 'Entroncamento', 'Ferreira do Zêzere', 'Golegã', 'Mação', 'Ourém', 'Rio Maior', 'Salvaterra de Magos', 'Sardoal', 'Tomar', 'Torres Novas', 'Vila Nova da Barquinha']],
            ['Setúbal',         ['Setúbal', 'Alcácer do Sal', 'Alcochete', 'Almada', 'Barreiro', 'Grândola', 'Moita', 'Montijo', 'Palmela', 'Santiago do Cacém', 'Seixal', 'Sesimbra', 'Sines']],
            ['Viana do Castelo',['Viana do Castelo', 'Arcos de Valdevez', 'Caminha', 'Melgaço', 'Monção', 'Paredes de Coura', 'Ponte da Barca', 'Ponte de Lima', 'Valença', 'Vila Nova de Cerveira']],
            ['Vila Real',       ['Vila Real', 'Alijó', 'Boticas', 'Chaves', 'Mesão Frio', 'Mondim de Basto', 'Montalegre', 'Murça', 'Peso da Régua', 'Ribeira de Pena', 'Sabrosa', 'Santa Marta de Penaguião', 'Valpaços', 'Vila Pouca de Aguiar']],
            ['Viseu',           ['Viseu', 'Armamar', 'Carregal do Sal', 'Castro Daire', 'Cinfães', 'Lamego', 'Mangualde', 'Moimenta da Beira', 'Mortágua', 'Nelas', 'Oliveira de Frades', 'Penalva do Castelo', 'Penedono', 'Resende', 'Santa Comba Dão', 'São João da Pesqueira', 'São Pedro do Sul', 'Sátão', 'Sernancelhe', 'Tabuaço', 'Tarouca', 'Tondela', 'Vila Nova de Paiva', 'Viseu', 'Vouzela']],
        ];

        foreach ($portugalCities as [$stateName, $cities]) {
            $sid = $stateId($portugal, $stateName);
            if (! $sid) continue;
            foreach (array_unique($cities) as $city) {
                DB::table('cities')->insertOrIgnore([
                    'country_id' => $portugal,
                    'state_id'   => $sid,
                    'name'       => $city,
                    'location'   => 'Europe',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        /* ─── Cidades de Moçambique ─── */
        $mocambiqueCities = [
            ['Cabo Delgado',    ['Pemba', 'Chiúre', 'Ibo', 'Macomia', 'Mecufi', 'Meluco', 'Metuge', 'Mocímboa da Praia', 'Montepuez', 'Mueda', 'Muidumbe', 'Nangade', 'Palma', 'Quissanga']],
            ['Gaza',            ['Xai-Xai', 'Bilene', 'Chibuto', 'Chicualacuala', 'Chigubo', 'Chokwé', 'Chongoene', 'Guijá', 'Limpopo', 'Mabalane', 'Manjacaze', 'Mapai', 'Massingir']],
            ['Inhambane',       ['Inhambane', 'Funhalouro', 'Govuro', 'Homoine', 'Inharrime', 'Inhassoro', 'Jangamo', 'Mabote', 'Massinga', 'Maxixe', 'Morrumbene', 'Panda', 'Vilankulo', 'Zavala']],
            ['Manica',          ['Chimoio', 'Báruè', 'Gondola', 'Guro', 'Machaze', 'Macossa', 'Manica', 'Mossurize', 'Sussundenga', 'Tambara']],
            ['Maputo',          ['Matola', 'Boane', 'Magude', 'Manhiça', 'Marracuene', 'Matutuíne', 'Moamba', 'Namaacha']],
            ['Cidade de Maputo',['Maputo', 'KaMpfumo', 'Nlhamankulu', 'KaMaxaqueni', 'KaMavota', 'KaMubukwana', 'KaTembe', 'KaNyaka']],
            ['Nampula',         ['Nampula', 'Angoche', 'Eráti', 'Ilha de Moçambique', 'Lalaua', 'Larde', 'Liúpo', 'Malema', 'Meconta', 'Mecuburi', 'Memba', 'Mogincual', 'Mogovolas', 'Moma', 'Monapo', 'Mossuril', 'Muecate', 'Murrupula', 'Nacarôa', 'Namarrói', 'Ribáuè']],
            ['Niassa',          ['Lichinga', 'Chimbonila', 'Cuamba', 'Lago', 'Majune', 'Mandimba', 'Marrupa', 'Maúa', 'Mavago', 'Mecanhelas', 'Mecula', 'Metarica', 'Muembe', 'Ngauma', 'Nipepe', 'Sanga']],
            ['Sofala',          ['Beira', 'Buzi', 'Caia', 'Chemba', 'Cheringoma', 'Chibabava', 'Dondo', 'Gorongosa', 'Machanga', 'Maringue', 'Marromeu', 'Muanza', 'Nhamatanda']],
            ['Tete',            ['Tete', 'Angónia', 'Cahora-Bassa', 'Changara', 'Chifunde', 'Chiuta', 'Dôa', 'Macanga', 'Magoé', 'Marara', 'Mágoè', 'Moatize', 'Mutarara', 'Tsangano', 'Zumbo']],
            ['Zambézia',        ['Quelimane', 'Alto Molócuè', 'Chinde', 'Gilé', 'Guruè', 'Ile', 'Inhassunge', 'Lugela', 'Luabo', 'Machanga', 'Maganja da Costa', 'Milange', 'Mocuba', 'Mopeia', 'Morrumbala', 'Namacurra', 'Namarrói', 'Nicoadala', 'Pebane']],
        ];

        foreach ($mocambiqueCities as [$stateName, $cities]) {
            $sid = $stateId($mocambique, $stateName);
            if (! $sid) continue;
            foreach ($cities as $city) {
                DB::table('cities')->insertOrIgnore([
                    'country_id' => $mocambique,
                    'state_id'   => $sid,
                    'name'       => $city,
                    'location'   => 'Africa',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $this->command->info('✅  LocationSeeder concluído com sucesso!');

    }
}
