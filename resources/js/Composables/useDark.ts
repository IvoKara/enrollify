const colorMode = useColorMode({
  storageKey: 'theme',
})

export function useDark() {
  const isDark = computed({
    get: () => colorMode.value === 'dark',
    set: (value) => {
      if (value) {
        colorMode.value = 'dark'
      }
      else {
        colorMode.value = 'light'
      }
    },
  },
  )
  return isDark
}
