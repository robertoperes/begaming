<template>
  <div class="container text-justify">
    <div>
      <h1>BADGES</h1>
      <h6>RECONHECER E INCENTIVAR FAZ O NOSSO ORGULHO BRILHAR</h6>
      <p>Os valores da Before são baseados em uma série de fatores positivos tanto para o lado pessoal quanto
        profissional de quem faz parte da empresa. Alinhado a isso, nós temos um programa de reconhecimento, que avalia
        e pontua os colaboradores diante de determinadas ações e atitudes.</p>
      <p>
        O objetivo dos Badges é fortalecer a cultura da Before em você ser a sua melhor versão, estando em um lugar que
        você gosta. Quanto mais Badges a pessoa ganha, mais evidência que ela vive, de fato, a cultura da empresa e se
        envolve com todas as ações que fazemos voltadas para evolução profissional e qualidade de vida.
      </p>
      <p>
        Eles funcionam como "medalhas", que dentro da Before são alcançadas quando cada colaborador consegue atingir o
        nível de pontuação em cada categoria, que incluem ações voltadas para o bem-estar, capacitação profissional,
        atingimento das metas, compartilhamento de conhecimento, entre outros.
      </p>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <caption>* Anual (Zera na passagem de nível exceto Admiração, Cultura e Tempo de Empresa)</caption>
        <thead>
        <tr>
          <th>
            Badges
          </th>
          <th class="text-center">Indicador</th>
          <th class="text-center">Classic</th>
          <th class="text-center">Silver</th>
          <th class="text-center">Gold</th>
          <th class="text-center">Black</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td><img src="/images/badges/type/bem-estar-classic.png" width="10"> Bem estar</td>
          <td class="text-center">Pontos</td>
          <td class="text-center">180</td>
          <td class="text-center">280</td>
          <td class="text-center">380</td>
          <td class="text-center">480</td>
        </tr>
        <tr>
          <td><img src="/images/badges/type/cursos-palestras-classic.png" width="10"> Evolução</td>
          <td class="text-center">Pontos</td>
          <td class="text-center">180</td>
          <td class="text-center">300</td>
          <td class="text-center">420</td>
          <td class="text-center">540</td>
        </tr>
        <tr>
          <td><img src="/images/badges/type/tempo-empresa-classic.png" width="10"> Tempo de empresa</td>
          <td class="text-center">Anos</td>
          <td class="text-center">4</td>
          <td class="text-center">8</td>
          <td class="text-center">12</td>
          <td class="text-center">16</td>
        </tr>
        <tr>
          <td><img src="/images/badges/type/admiracao-classic.png" width="10"> Admiração</td>
          <td class="text-center">Pontos</td>
          <td class="text-center">2</td>
          <td class="text-center">4</td>
          <td class="text-center">6</td>
          <td class="text-center">8</td>
        </tr>
        <tr>
          <td><img src="/images/badges/type/cultura-classic.png" width="10"> Cultura</td>
          <td class="text-center">Pontos</td>
          <td class="text-center">4</td>
          <td class="text-center">8</td>
          <td class="text-center">12</td>
          <td class="text-center">16</td>
        </tr>
        <tr>
          <td><img src="/images/badges/type/engajamento-classic.png" width="10"> Engajamento</td>
          <td class="text-center">Pontos</td>
          <td class="text-center">240</td>
          <td class="text-center">280</td>
          <td class="text-center">320</td>
          <td class="text-center">360</td>
        </tr>
        </tbody>
      </table>
      </div>
    </div>
    <badge-role-info v-for="item in this.badgesInfo" :badge="item" :key="item.title"/>
  </div>
</template>

<script>
import BadgeRoleInfo from "./BadgeRoleInfo";
export default {
  components: {BadgeRoleInfo},
  data(){
    return {
      badgesInfo: [
        {
          icon:'bem-estar-classic.png',
          title: 'Bem-Estar',
          description: 'Este Badge demonstra exatamente como queremos que você esteja ao nosso lado: BEM! Ele pontua ações relacionadas à qualidade de vida e saúde, como prática de atividade física e participação em eventos esportivos, etc. É um estímulo para termos uma vida mais saudável!',
          roles: [
              'Ao longo do ano iremos realizar várias ações para desafiar você a colocar seu bem estar em dia. A cada participação você garante seus pontos! Se você participar de competições esportivas e/ou doar sangue, consegue ainda mais pontos, envie o comprovante no e-mail da dayane.eurico@before.com.br e nayara.deniz@before.com.br com cópia para a paula.santana@before.com.br.'
          ],
          points: [
            {
              description: 'Competição interna - Vencedor da competição',
              point: 10,
              observation: 'Por participação'
            },
            {
              description: 'Competição esportiva',
              point: 10,
              observation: 'Por competição comprovada enviada para o e-mail do RH'
            },
            {
              description: 'Doar Sangue/Plaquetas',
              point: 20,
              observation: 'Por comprovação enviada para o e-mail do RH'
            },
            {
              description: 'Atividade física',
              point: 1,
              observation: 'Por dia de atividade física comprovada no Strava'
            },
          ]
        },
        {
          icon:'cursos-palestras-classic.png',
          title: 'Evolução',
          description: 'Estimular a procura pelo novo e impulsionar a sua evolução faz parte deste Badge. Ele valoriza as ações de desenvolvimento profissional, como graduações, participação em cursos e palestras presenciais ou online, concluir PDI e ter um resultado de alto potencial na Avaliação de Desempenho. Um grande incentivo para buscarmos nossa evolução!',
          roles: [],
          points: [
            {
              description: 'Curso ou palestra',
              point: 1,
              observation: 'Por hora de curso comprovado'
            },
            {
              description: 'Curso graduação ou pós-graduação',
              point: 0.15,
              observation: 'Por hora de curso comprovado'
            },
            {
              description: 'Palestrar em evento interno ou externo',
              point: 10,
              observation: 'Por comprovação enviada para o e-mail do RH'
            },
            {
              description: 'Artigo para o blogue',
              point: 10,
              observation: 'Por artigo postado no blogue da Before'
            },
            {
              description: 'PDI concluído',
              point: 10,
              observation: 'Por PDI concluído'
            },
            {
              description: ' AVD - Forte desempenho/comportamento',
              point: 10,
              observation: 'Conforme resultado do 9box'
            },
            {
              description: 'AVD - Estrela',
              point: 20,
              observation: 'Conforme resultado do 9box'
            },
          ]
        },
        {
          icon:'tempo-empresa-classic.png',
          title: 'Tempo de Empresa',
          description: 'Este Badge valoriza as relações duradouras e a dedicação. Fique tranquilo, o tempo de trabalho na Before lhe dará essa conquista. O ciclo de premiação acontece de 4 em 4 anos.',
          roles: [
          ],
          points: [
            {
              description: '4 anos de empresa',
              point: 4,
              observation: ''
            },
            {
              description: '8 anos de empresa',
              point: 4,
              observation: ''
            },
            {
              description: '12 anos de empresa',
              point: 4,
              observation: ''
            },
            {
              description: '16 anos de empresa',
              point: 4,
              observation: ''
            },
          ]
        },
        {
          icon:'admiracao-classic.png',
          title: 'Admiração',
          description: 'Sabe quando você faz algo e desperta reações das pessoas? É assim que funciona este Badge, que também é conhecido como “Badge do elogio”. Ele reconhece formalmente os elogios recebidos. Uma forma de mostrar que todos reconhecem suas virtudes!',
          roles: [
              'Todo elogio deve ser publicado no mural de Celebração da Feedz. No dia 5 iremos gerar um relatório e pontuar os elogios.',
              'Será aceito um elogio por tipo de ação. Exemplo: Se mais de uma pessoa do time, elogiou que você teve a iniciativa de dar um treinamento, será válido apenas 1 elogio e não o de todos os colegas que elogiaram a ação. Mas se a mesma ação recebe um elogio do time e do cliente, conta como 2 pontos.',
              'Todo dia 05 iremos gerar um relatório das celebrações e pontuar as válidas.',
              'Observação: Não será válido celebrações de aniversário, boas-vindas, promoção, elogios referente a entregas do dia-a-dia do time e agradecimentos genéricos.',
              'Se surgir outro tipo de elogio que não estava previsto, será votado pela liderança se o elogio irá pontuar ou não.',
          ],
          points: [
            {
              description: 'Entrega de sucesso / empenho do time',
              point: 1,
              observation: 'Quando recebe um elogio do cliente'
            },
            {
              description: 'Melhoria / Iniciativa para melhoria',
              point: 1,
              observation: 'Quando faz alguma melhoria no time (tecnologia, processos...)'
            },
            {
              description: 'Iniciativa de aprendizado',
              point: 1,
              observation: 'Quando faz algum treinamento, dojô, compartilha seu conhecimento de alguma forma'
            },
            {
              description: 'Iniciativa de integração',
              point: 1,
              observation: 'Quando é feito alguma ação para aproximação e maior interação com o time ou com os demais colaboradores'
            },
            {
              description: 'Iniciativa para colaboração',
              point: 1,
              observation: 'Quando alguém colabora positivamente com ações para outro projeto ou para a Before'
            },
          ]
        },
        {
          icon:'cultura-classic.png',
          title: 'Cultura',
          description: 'Aqui está o reconhecimento do reconhecimento. Quanto mais Badges você tiver, mais perto de ganhar este você estará. \n' +
              'Por isso, viva intensamente a cultura da Before!',
          roles: [
              'Todos os badges contabilizam exceto o badge de Cultura.'
          ],
          points: [
            {
              description: 'Badges diferentes ganhos - Classic',
              point: 1,
              observation: 'Quantidade de badges distintos ganhos'
            },
            {
              description: 'Badges diferentes ganhos - Silver',
              point: 2,
              observation: 'Quantidade de badges distintos ganhos'
            },
            {
              description: 'Badges diferentes ganhos - Gold',
              point: 3,
              observation: 'Quantidade de badges distintos ganhos'
            },
            {
              description: 'Badges diferentes ganhos - Black',
              point: 4,
              observation: 'Quantidade de badges distintos ganhos'
            },
          ]
        },
        {
          icon:'engajamento-classic.png',
          title: 'Engajamento',
          description: 'Este badge valoriza o seu envolvimento com a Before. Quanto mais você contribui se envolvendo nas ações da empresa e nos processos de engajamento da Feedz, mais pontos você ganha.',
          roles: [],
          points: [
            {
              description: 'Competição interna - Vencedor da competição',
              point: 5,
              observation: 'Ser campeão na competição'
            },
            {
              description: 'Competição interna - Participação',
              point: 3,
              observation: 'Participação aos eventos de competição interna'
            },
            {
              description: 'Indicar profissionais para as vagas abertas (ser contratado)',
              point: 20,
              observation: 'Indicação válida somente de currículos encaminhados diretamente para o RH'
            },
            {
              description: 'Participação em eventos internos',
              point: 2,
              observation: 'Precisa responder o formulário de satisfação do evento na Feedz para pontuar'
            },
            {
              description: 'Gamificação da Feeds',
              point: 1,
              observation: 'Pontuação total dentro do mês de todos os itens da feedz que são gamificados'
            }
          ]
        }
      ]
    };
  }
}
</script>

<style scoped>

  h1, h2, h3, h4, h5, h6{
    color: #f86e32;
    font-weight: bold;
  }

  table {
    font-size: 14px;
  }
  th {
    font-weight: bold;
    text-transform: uppercase;
    background-color: #f86e32;
    color: white;
  }

</style>