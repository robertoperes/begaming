export const reset = (initial) => (state, ignore = []) => {
  const ignoreState = ignore.reduce((result, key) => { result[key] = state[key]; return result; }, {});
  Object.keys(state).map(key => {
    state[key] = ignoreState[key] || initial[key];
  });
};