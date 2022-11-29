@extends('layouts.app')

@push('styles_scripts')
<style>
    h1 {
        text-align: center;
    }

    p {
        font-size: 1.4em;
        text-align: justify;
        text-justify: inter-word;
    }
</style>
@endpush

@section('content')

    <section class="main-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1> OnPoint </h1>
                    <p>
                        Desde o início de 2020, a humanidade passou por uma terrível situação, o novo coronavírus,
                        covid-19. Com o caos gerado pela pandemia, o mundo teve de se adaptar a diversas novas
                        situações. Quando focamos no segmento corporativo, podemos notar a tendência de uma rápida
                        adoção do modelo de trabalho remoto ou híbrido, a fim de proteger os trabalhadores das condições
                        causadas pela pandemia. As consequências da epidemia de covid-19 permaneceram no ambiente
                        empresarial no período de pós-pandemia, muitos funcionários recusaram o retorno ao modelo
                        presencial. De acordo com um levantamento realizado pelo Ministério da Economia, duas grandes
                        empresas brasileiras (ATENTO e BRF) consideram que o modelo de trabalho híbrido se manterá mesmo
                        após a normalização do dia-a-dia. Devido a isso, este artigo pretende demonstrar como será
                        possível aplicar uma solução de localização indoor para monitorar cada colaborador de uma grande
                        empresa, e entender o seu comportamento e readaptação aos escritórios presenciais. Além disso,
                        o sistema irá apresentar métricas que indicam a utilização dos ambientes a fim de identificar
                        pontos de investimento e mudanças na infraestrutura da empresa. O Sistema de Monitoramento
                        Síncrono de Circulação de Pessoas em Ambiente Determinado aborda métodos para melhorar a
                        administração e gestão de pessoas e ambientes corporativos com o objetivo de facilitar a tomada
                        de decisão e consequentemente aumentar a segurança, produtividade e bem-estar dos colaboradores.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
