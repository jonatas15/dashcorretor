# dashcorretor

This template should help get you started developing with Vue 3 in Vite.

## Recommended IDE Setup

[VSCode](https://code.visualstudio.com/) + [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur) + [TypeScript Vue Plugin (Volar)](https://marketplace.visualstudio.com/items?itemName=Vue.vscode-typescript-vue-plugin).

## Customize configuration

See [Vite Configuration Reference](https://vitejs.dev/config/).

## Project Setup

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

### Compile and Minify for Production

```sh
npm run build
```

### NOTAS DO DESENVOLVEDOR:
# CÓDIGO SCRIPT PELO HELENA APP JÁ COM A CHAVE DE AUTORIZAÇÃO DEFINIDA
```sh

  const options = {
    method: 'POST',
    headers: {
      accept: 'application/json',
      'content-type': 'application/*+json',
      Authorization: 'pn_UYnqnIu6TQoUd84Onb8I2WILUxCWFhuRR2q9ZXYLc'
    },
    body: '{"body":{"text":"Api de funcionamento via javascript funcionando"},"to":"99991609507"}'
  };

  fetch('https://api.helena.run/chat/v1/message/send', options)
    .then(response => response.json())
    .then(response => console.log(response))
    .catch(err => console.error(err));

```